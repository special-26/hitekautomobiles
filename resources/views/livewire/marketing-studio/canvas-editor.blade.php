
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('marketing-studio.index') }}"
               class="text-sm text-slate-500 hover:text-hitek-red">
                ← Back to Marketing Studio
            </a>

            <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                {{ $template?->name ?? 'Template Editor' }}
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Select a predefined element to edit its content.
            </p>
        </div>

        @if ($template)
            <div class="text-sm text-slate-500 dark:text-slate-400">
                {{ ucfirst($template->format) }} ·
                {{ $template->width }} × {{ $template->height }} px
            </div>
        @endif
    </div>

    @if (!$template)
        <div class="rounded-xl border border-dashed border-slate-300 p-10 text-center dark:border-slate-700">
            <h2 class="font-semibold text-slate-900 dark:text-white">
                Select a template to get started
            </h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Choose a design from the Marketing Studio gallery.
            </p>
            <a href="{{ route('marketing-studio.index') }}"
               class="mt-4 inline-flex rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover">
                Browse templates
            </a>
        </div>
    @else
        <div
            class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_300px]"
            
            x-data="{
                selectedId: null,
                selectedElement: null,
                values: {{ Illuminate\Support\Js::from($template->design['elements'] ?? []) }},
                canvasEditor: null,
                canvasReady: false,

                canvasConfig: {{ Illuminate\Support\Js::from([
                    'width' => $template->width,
                    'height' => $template->height,
                    'background' => $template->design['background'] ?? '#ffffff',
                    'elements' => $template->design['elements'] ?? [],
                    'logoUrl' => $profile?->logo_path
                        ? asset('storage/' . $profile->logo_path)
                        : null,
                ]) }},

                async initializeCanvas(canvasElement) {
                    try {
                        this.canvasEditor = await window.initMarketingStudioCanvas(
                            canvasElement,
                            this.canvasConfig,
                            {
                                onSelect: (object) => {
                                    const id = object?.data?.elementId ?? null;

                                    this.selectedId = id;
                                    this.selectedElement = id
                                        ? this.values.find(item => item.id === id) ?? null
                                        : null;
                                },

                                onModified: (object, updatedElement) => {
                                    if (!updatedElement) return;

                                    const element = this.values.find(
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
                                }
                            }
                        );

                        this.canvasReady = true;
                    } catch (error) {
                        console.error(
                            'Marketing Studio canvas initialization failed:',
                            error
                        );
                    }
                },

                selectElement(element) {
                    if (!element || element.editable === false) return;

                    const object = this.canvasEditor?.getObjectByElementId(element.id);

                    if (object) {
                        this.canvasEditor.canvas.setActiveObject(object);
                        this.canvasEditor.canvas.requestRenderAll();
                    }
                },

                updateSelectedElement(property, value) {
                    if (!this.selectedElement) return;
                    if (this.selectedElement.editable === false) return;

                    this.selectedElement[property] = value;

                    const index = this.values.findIndex(
                        item => item.id === this.selectedElement.id
                    );

                    if (index !== -1) {
                        this.values[index][property] = value;
                    }

                    this.canvasEditor?.updateElement(
                        this.selectedElement.id,
                        property,
                        value
                    );
                }
            }"

        >
            <section class="min-w-0 rounded-xl border border-slate-200 bg-slate-100 p-4 dark:border-slate-800 dark:bg-slate-950">
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-slate-900 dark:text-white">
                            Design preview
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Select an element below to edit it.
                        </p>
                    </div>
                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        {{ $template->width }} × {{ $template->height }}
                    </span>
                </div>

                <div
                    class="mx-auto w-full max-w-[650px] overflow-hidden rounded-lg shadow-lg"
                >
                    <div
                        class="relative w-full overflow-hidden"
                        style="
                            aspect-ratio: {{ $template->width }} / {{ $template->height }};
                            background: {{ $template->design['background'] ?? '#ffffff' }};
                        "
                    >
                        <canvas
                            x-ref="fabricCanvas"
                            x-init="initializeCanvas($el)"
                            width="{{ $template->width }}"
                            height="{{ $template->height }}"
                            class="block h-full w-full"
                        ></canvas>
                    </div>

                    <p
                        x-show="!canvasReady"
                        class="mt-2 text-xs text-slate-500 dark:text-slate-400"
                    >
                        Initializing design preview…
                    </p>
                </div>

            </section>

            <aside class="space-y-4 rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
                <h2 class="font-semibold text-slate-900 dark:text-white">
                    Edit selected element
                </h2>

                <template x-if="!selectedElement">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Click a heading, subtitle or image in the preview.
                    </p>
                </template>

                <template x-if="selectedElement">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-slate-400">
                                Element type
                            </p>
                            <p class="mt-1 font-medium text-slate-900 dark:text-white"
                               x-text="selectedElement.type"></p>
                        </div>

                        <template x-if="selectedElement.type === 'text'">
                            <div class="space-y-4">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Text content
                                    </label>
                                    
                                    <textarea
                                        rows="3"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                        x-model="selectedElement.text"
                                        x-on:input="updateSelectedElement('text', $event.target.value)"
                                    ></textarea>

                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Font size
                                    </label>
                                    <input
                                        type="number"
                                        min="8"
                                        max="120"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                        :value="selectedElement.fontSize || 32"
                                        @input="updateSelectedElement('fontSize', Math.max(8, Math.min(120, Number($event.target.value) || 32)))"
                                    >
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Text color
                                    </label>
                                    <input
                                        type="color"
                                        class="h-10 w-full cursor-pointer rounded-lg border border-slate-300 bg-white p-1 dark:border-slate-700 dark:bg-slate-800"
                                        :value="selectedElement.color || '#ffffff'"
                                        @input="updateSelectedElement('color', $event.target.value)"
                                    >
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Font weight
                                    </label>
                                    <select
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                        :value="selectedElement.fontWeight || 'bold'"
                                        @change="updateSelectedElement('fontWeight', $event.target.value)"
                                    >
                                        <option value="normal">Regular</option>
                                        <option value="500">Medium</option>
                                        <option value="bold">Bold</option>
                                        <option value="900">Extra bold</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Font family
                                    </label>

                                    <select
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                        :value="selectedElement.fontFamily || 'Arial'"
                                        @change="updateSelectedElement('fontFamily', $event.target.value)"
                                    >
                                        <option value="Arial">Arial — Clean</option>
                                        <option value="Inter">Inter — Modern</option>
                                        <option value="Georgia">Georgia — Classic</option>
                                        <option value="Impact">Impact — Bold</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Line spacing
                                    </label>

                                    <select
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                        :value="selectedElement.lineHeight || 1.2"
                                        @change="updateSelectedElement('lineHeight', Number($event.target.value))"
                                    >
                                        <option value="1">Compact</option>
                                        <option value="1.2">Normal</option>
                                        <option value="1.5">Relaxed</option>
                                        <option value="1.8">Wide</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Letter spacing
                                    </label>

                                    <input
                                        type="number"
                                        min="-2"
                                        max="12"
                                        step="0.5"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                        :value="selectedElement.letterSpacing ?? 0"
                                        @input="updateSelectedElement('letterSpacing', Math.max(-2, Math.min(12, Number($event.target.value) || 0)))"
                                    >

                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                        Adjust the spacing between characters.
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                        Text alignment
                                    </label>

                                    <div class="grid grid-cols-3 gap-2">
                                        <button
                                            type="button"
                                            class="flex items-center justify-center rounded-lg border px-3 py-2 text-sm transition"
                                            :class="(selectedElement.textAlign || 'center') === 'left'
                                                ? 'border-hitek-red bg-red-50 text-hitek-red dark:bg-red-950'
                                                : 'border-slate-300 text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800'"
                                            @click="updateSelectedElement('textAlign', 'left')"
                                            aria-label="Align text left"
                                        >
                                            Left
                                        </button>

                                        <button
                                            type="button"
                                            class="flex items-center justify-center rounded-lg border px-3 py-2 text-sm transition"
                                            :class="(selectedElement.textAlign || 'center') === 'center'
                                                ? 'border-hitek-red bg-red-50 text-hitek-red dark:bg-red-950'
                                                : 'border-slate-300 text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800'"
                                            @click="updateSelectedElement('textAlign', 'center')"
                                            aria-label="Align text center"
                                        >
                                            Center
                                        </button>

                                        <button
                                            type="button"
                                            class="flex items-center justify-center rounded-lg border px-3 py-2 text-sm transition"
                                            :class="(selectedElement.textAlign || 'center') === 'right'
                                                ? 'border-hitek-red bg-red-50 text-hitek-red dark:bg-red-950'
                                                : 'border-slate-300 text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800'"
                                            @click="updateSelectedElement('textAlign', 'right')"
                                            aria-label="Align text right"
                                        >
                                            Right
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template x-if="selectedElement.type === 'image'">
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Replace vehicle image
                                </label>

                                <input
                                    type="file"
                                    accept="image/png,image/jpeg,image/webp"
                                    class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-hitek-red file:px-3 file:py-2 file:font-medium file:text-white dark:text-slate-300"
                                    @change="
                                        const file = $event.target.files[0];
                                        if (!file) return;

                                        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                                            alert('Please select a JPG, PNG, or WebP image.');
                                            $event.target.value = '';
                                            return;
                                        }

                                        if (file.size > 5 * 1024 * 1024) {
                                            alert('Please select an image smaller than 5 MB.');
                                            $event.target.value = '';
                                            return;
                                        }

                                        const reader = new FileReader();

                                        reader.onload = (event) => {
                                            updateSelectedElement('src', event.target.result);
                                        };

                                        reader.readAsDataURL(file);
                                    "
                                >

                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    JPG, PNG or WebP. Maximum file size: 5 MB.
                                    The image is only previewed in your browser at this stage.
                                </p>
                            </div>
                        </template>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Changes currently affect this preview only. Saving and exporting will be added next.
                        </p>
                    </div>
                </template>
            </aside>
        </div>
    @endif
</div>
