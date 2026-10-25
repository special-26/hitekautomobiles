
import {
    Canvas,
    Textbox,
    Rect,
    FabricImage,
} from 'fabric';

const editors = new WeakMap();

function getPosition(element, width, height) {
    return {
        left: (Number(element.x ?? 0) / 100) * width,
        top: (Number(element.y ?? 0) / 100) * height,
        width: (Number(element.width ?? 10) / 100) * width,
        height: (Number(element.height ?? 10) / 100) * height,
    };
}

function getObjectOptions(element) {
    const editable = element.editable === true;

    return {
        originX: 'left',
        originY: 'top',
        selectable: editable,
        evented: editable,
        hasControls: editable,
        lockMovementX: !editable,
        lockMovementY: !editable,
        lockScalingX: !editable,
        lockScalingY: !editable,
        objectCaching: false,
        data: {
            elementId: element.id,
            elementType: element.type,
            editable,
        },
    };
}

function createTextObject(element, config) {
    const position = getPosition(element, config.width, config.height);

    const object = new Textbox(element.text ?? '', {
        ...position,
        ...getObjectOptions(element),
        fontSize: Number(element.fontSize ?? 32),
        fontFamily: element.fontFamily ?? 'Arial',
        fontWeight: element.fontWeight ?? 'normal',
        fill: element.color ?? '#ffffff',
        textAlign: element.textAlign ?? 'center',
        lineHeight: Number(element.lineHeight ?? 1.2),
        charSpacing: Number(element.letterSpacing ?? 0) * 10,
        splitByGrapheme: false,
    });

    if (element.background) {
        object.set('textBackgroundColor', element.background);
    }

    return object;
}

function createPlaceholder(element, config, message = '') {
    const position = getPosition(element, config.width, config.height);

    return new Rect({
        ...position,
        ...getObjectOptions(element),
        fill: '#334155',
        stroke: '#94a3b8',
        strokeDashArray: [8, 5],
        strokeWidth: 2,
        data: {
            ...getObjectOptions(element).data,
            placeholder: true,
            message,
        },
    });
}

async function createImageObject(element, config) {
    const src = element.type === 'brand_logo'
        ? config.logoUrl
        : element.src;

    if (!src) {
        return createPlaceholder(
            element,
            config,
            element.type === 'brand_logo'
                ? 'Hitek logo not configured'
                : 'Vehicle image not selected',
        );
    }

    const image = await FabricImage.fromURL(src, {
        crossOrigin: 'anonymous',
    });

    const position = getPosition(element, config.width, config.height);
    const scaleX = position.width / image.width;
    const scaleY = position.height / image.height;

    // Fit the image inside its allocated area without stretching it.
    const scale = element.fit === 'cover'
        ? Math.max(scaleX, scaleY)
        : Math.min(scaleX, scaleY);

    image.set({
        left: position.left,
        top: position.top,
        ...getObjectOptions(element),
        scaleX: scale,
        scaleY: scale,
    });

    return image;
}

export async function initMarketingStudioCanvas(
    canvasElement,
    config,
    callbacks = {},
) {
    if (!canvasElement || !config) {
        throw new Error('Canvas element and template configuration are required.');
    }

    editors.get(canvasElement)?.dispose();
    editors.delete(canvasElement);

    const canvas = new Canvas(canvasElement, {
        width: config.width,
        height: config.height,
        backgroundColor: config.background ?? '#ffffff',
        preserveObjectStacking: true,
        selection: true,
        stopContextMenu: true,
    });

    const editor = {
        canvas,
        config,
        callbacks,
        disposed: false,

        getObjectByElementId(id) {
            return canvas.getObjects().find(
                object => object.data?.elementId === id,
            ) ?? null;
        },

        async updateElement(id, property, value) {
            const object = this.getObjectByElementId(id);

            if (!object || object.data?.editable !== true) {
                return;
            }

            if (property === 'src' && object.data.elementType === 'image') {
                await this.replaceImage(id, value);
                return;
            }

            const propertyMap = {
                text: 'text',
                fontSize: 'fontSize',
                fontFamily: 'fontFamily',
                fontWeight: 'fontWeight',
                color: 'fill',
                textAlign: 'textAlign',
                lineHeight: 'lineHeight',
                letterSpacing: 'charSpacing',
                background: 'textBackgroundColor',
            };

            const fabricProperty = propertyMap[property];

            if (!fabricProperty) {
                return;
            }

            const nextValue = property === 'letterSpacing'
                ? Number(value) * 10
                : value;

            object.set(fabricProperty, nextValue);

            if (object instanceof Textbox) {
                object.initDimensions();
            }

            object.setCoords();
            canvas.requestRenderAll();
        },
        
        async replaceImage(id, src) {
            const oldObject = this.getObjectByElementId(id);

            if (!oldObject || oldObject.data?.editable !== true) {
                return;
            }

            const element = this.config.elements.find(item => item.id === id);

            if (!element || element.type !== 'image') {
                return;
            }

            try {
                const image = await FabricImage.fromURL(src, {
                    crossOrigin: 'anonymous',
                });

                // Preserve the current object's actual displayed bounds.
                const bounds = oldObject.getBoundingRect();

                const targetWidth = bounds.width;
                const targetHeight = bounds.height;

                const scaleX = targetWidth / image.width;
                const scaleY = targetHeight / image.height;

                // Maintain the image's aspect ratio.
                const scale = element.fit === 'cover'
                    ? Math.max(scaleX, scaleY)
                    : Math.min(scaleX, scaleY);

                image.set({
                    left: bounds.left,
                    top: bounds.top,
                    scaleX: scale,
                    scaleY: scale,
                    ...getObjectOptions(element),
                });

                canvas.remove(oldObject);
                canvas.add(image);
                canvas.setActiveObject(image);
                canvas.requestRenderAll();

                callbacks.onSelect?.(image);
            } catch (error) {
                console.error('Unable to replace template image:', error);
            }
        },


        resizeTo(containerWidth) {
            const scale = Math.min(
                containerWidth / config.width,
                1,
            );

            canvas.setDimensions({
                width: Math.round(config.width * scale),
                height: Math.round(config.height * scale),
            });

            canvas.setViewportTransform([
                scale, 0, 0, scale, 0, 0,
            ]);

            canvas.requestRenderAll();
        },

        dispose() {
            this.disposed = true;
            observer.disconnect();
            canvas.dispose();
        },
    };

    for (const element of config.elements ?? []) {
        let object;

        if (element.type === 'text' || element.type === 'brand_text') {
            object = createTextObject(element, config);
        } else if (
            element.type === 'image' ||
            element.type === 'brand_logo'
        ) {
            try {
                object = await createImageObject(element, config);
            } catch (error) {
                console.error(`Unable to load image "${element.id}":`, error);
                object = createPlaceholder(element, config, 'Image unavailable');
            }
        } else {
            continue;
        }

        canvas.add(object);
    }

    canvas.on('selection:created', event => {
        callbacks.onSelect?.(event.selected?.[0] ?? null);
    });

    canvas.on('selection:updated', event => {
        callbacks.onSelect?.(event.selected?.[0] ?? null);
    });

    canvas.on('selection:cleared', () => {
        callbacks.onSelect?.(null);
    });

    
    canvas.on('object:modified', event => {
        const object = event.target;

        if (!object || object.data?.editable !== true) {
            return;
        }

        const bounds = object.getBoundingRect();

        const updatedElement = {
            id: object.data.elementId,
            x: (bounds.left / config.width) * 100,
            y: (bounds.top / config.height) * 100,
            width: (bounds.width / config.width) * 100,
            height: (bounds.height / config.height) * 100,
        };

        // Keep the in-memory template data synchronized.
        const element = config.elements.find(
            item => item.id === updatedElement.id
        );

        if (element) {
            Object.assign(element, {
                x: updatedElement.x,
                y: updatedElement.y,
                width: updatedElement.width,
                height: updatedElement.height,
            });
        }

        callbacks.onModified?.(object, updatedElement);
    });


    const observer = new ResizeObserver(entries => {
        if (editor.disposed) return;

        const width = entries[0]?.contentRect.width;

        if (width > 0) {
            editor.resizeTo(width);
        }
    });

    observer.observe(canvasElement.parentElement);

    editors.set(canvasElement, editor);

    editor.resizeTo(canvasElement.parentElement.clientWidth);

    return editor;
}

window.initMarketingStudioCanvas = initMarketingStudioCanvas;
