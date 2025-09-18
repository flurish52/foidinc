<template>
    <div class="rich-editor">
        <!-- Toolbar -->
        <div class="toolbar">
            <!-- Text formatting -->
            <button @click="execCommand('bold')" :class="{ active: isCommandActive('bold') }" title="Bold">
                <strong>B</strong>
            </button>
            <button @click="execCommand('italic')" :class="{ active: isCommandActive('italic') }" title="Italic">
                <em>I</em>
            </button>
            <button @click="execCommand('underline')" :class="{ active: isCommandActive('underline') }" title="Underline">
                <u>U</u>
            </button>
            <button @click="execCommand('strikeThrough')" :class="{ active: isCommandActive('strikeThrough') }" title="Strikethrough">
                <s>S</s>
            </button>

            <div class="separator"></div>

            <!-- Headings -->
            <select @change="formatBlock($event)" class="format-select">
                <option value="">Format</option>
                <option value="p">Paragraph</option>
                <option value="h1">Heading 1</option>
                <option value="h2">Heading 2</option>
                <option value="h3">Heading 3</option>
                <option value="h4">Heading 4</option>
                <option value="h5">Heading 5</option>
                <option value="h6">Heading 6</option>
            </select>

            <div class="separator"></div>

            <!-- Lists -->
            <button @click="execCommand('insertOrderedList')" :class="{ active: isCommandActive('insertOrderedList') }" title="Ordered List">
                OL
            </button>
            <button @click="execCommand('insertUnorderedList')" :class="{ active: isCommandActive('insertUnorderedList') }" title="Unordered List">
                UL
            </button>
            <button @click="execCommand('indent')" title="Indent">→</button>
            <button @click="execCommand('outdent')" title="Outdent">←</button>

            <div class="separator"></div>

            <!-- Alignment -->
            <button @click="execCommand('justifyLeft')" :class="{ active: isCommandActive('justifyLeft') }" title="Align Left">
                ⫷
            </button>
            <button @click="execCommand('justifyCenter')" :class="{ active: isCommandActive('justifyCenter') }" title="Center">
                ≡
            </button>
            <button @click="execCommand('justifyRight')" :class="{ active: isCommandActive('justifyRight') }" title="Align Right">
                ⫸
            </button>
            <button @click="execCommand('justifyFull')" :class="{ active: isCommandActive('justifyFull') }" title="Justify">
                ▦
            </button>

            <div class="separator"></div>

            <!-- Font options -->
            <select @change="setFontName($event)" class="font-select">
                <option value="">Font</option>
                <option value="Arial">Arial</option>
                <option value="Helvetica">Helvetica</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Georgia">Georgia</option>
                <option value="Courier New">Courier New</option>
                <option value="Verdana">Verdana</option>
            </select>

            <select @change="setFontSize($event)" class="size-select">
                <option value="">Size</option>
                <option value="1">8pt</option>
                <option value="2">10pt</option>
                <option value="3">12pt</option>
                <option value="4">14pt</option>
                <option value="5">18pt</option>
                <option value="6">24pt</option>
                <option value="7">36pt</option>
            </select>

            <!-- Colors -->
            <input
                type="color"
                @change="setTextColor($event)"
                title="Text Color"
                class="color-input"
            >
            <input
                type="color"
                @change="setBackgroundColor($event)"
                title="Background Color"
                class="color-input"
            >

            <div class="separator"></div>

            <!-- Links and media -->
            <button @click="insertLink" title="Insert Link">🔗</button>
            <button @click="insertHorizontalRule" title="Horizontal Line">―</button>
            <input
                type="file"
                @change="handleImageUpload"
                accept="image/*"
                ref="imageInput"
                style="display: none"
            >
            <button @click="triggerImageUpload" title="Insert Image">📷</button>

            <div class="separator"></div>

            <!-- History -->
            <button @click="execCommand('undo')" title="Undo">↶</button>
            <button @click="execCommand('redo')" title="Redo">↷</button>
            <button @click="clearFormatting" title="Clear Formatting">🧹</button>
        </div>
        <!-- Editor -->
        <div
            ref="editor"
            class="editor-content"
            contenteditable="true"
            dir="ltr"
            @input="handleInput"
            @paste="handlePaste"
            @keydown="handleKeydown"
        ></div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    uploadUrl: {
        type: String,
        default: '/upload'
    }
})

const emit = defineEmits(['update:modelValue'])

const editor = ref(null)
const imageInput = ref(null)

// Initialize editor content
onMounted(() => {
    if (props.modelValue && editor.value) {
        editor.value.innerHTML = props.modelValue
    }
})

// Watch for external changes to modelValue
watch(() => props.modelValue, (newValue) => {
    if (editor.value && editor.value.innerHTML !== newValue) {
        editor.value.innerHTML = newValue || ''
    }
})

const handleInput = () => {
    if (editor.value) {
        emit('update:modelValue', editor.value.innerHTML)
    }
}

const execCommand = (command, value = null) => {
    document.execCommand(command, false, value)
    editor.value.focus()
    handleInput()
}

const isCommandActive = (command) => {
    try {
        return document.queryCommandState(command)
    } catch (e) {
        return false
    }
}

const formatBlock = (event) => {
    const value = event.target.value
    if (value) {
        execCommand('formatBlock', `<${value}>`)
        event.target.value = ''
    }
}

const setFontName = (event) => {
    const value = event.target.value
    if (value) {
        execCommand('fontName', value)
        event.target.value = ''
    }
}

const setFontSize = (event) => {
    const value = event.target.value
    if (value) {
        execCommand('fontSize', value)
        event.target.value = ''
    }
}

const setTextColor = (event) => {
    execCommand('foreColor', event.target.value)
}

const setBackgroundColor = (event) => {
    execCommand('backColor', event.target.value)
}

const insertLink = () => {
    const url = prompt('Enter URL:')
    if (url) {
        execCommand('createLink', url)
    }
}

const insertHorizontalRule = () => {
    execCommand('insertHorizontalRule')
}

const clearFormatting = () => {
    execCommand('removeFormat')
}

const triggerImageUpload = () => {
    imageInput.value.click()
}

const createResizableImage = (src) => {
    const container = document.createElement('div')
    container.className = 'image-container'
    container.style.cssText = `
    display: inline-block;
    position: relative;
    max-width: 100%;
    margin: 5px;
    border: 2px dashed transparent;
  `

    const img = document.createElement('img')
    img.src = src
    img.style.cssText = `
    max-width: 100%;
    height: auto;
    display: block;
  `

    const resizeHandle = document.createElement('div')
    resizeHandle.className = 'resize-handle'
    resizeHandle.style.cssText = `
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 10px;
    height: 10px;
    background: #007cba;
    cursor: se-resize;
    display: none;
  `

    container.appendChild(img)
    container.appendChild(resizeHandle)

    // Show/hide resize handle on hover
    container.addEventListener('mouseenter', () => {
        container.style.border = '2px dashed #007cba'
        resizeHandle.style.display = 'block'
    })

    container.addEventListener('mouseleave', () => {
        container.style.border = '2px dashed transparent'
        resizeHandle.style.display = 'none'
    })

    // Resize functionality
    let isResizing = false
    let startX, startY, startWidth, startHeight

    resizeHandle.addEventListener('mousedown', (e) => {
        isResizing = true
        startX = e.clientX
        startY = e.clientY
        startWidth = parseInt(document.defaultView.getComputedStyle(img).width, 10)
        startHeight = parseInt(document.defaultView.getComputedStyle(img).height, 10)
        e.preventDefault()
    })

    document.addEventListener('mousemove', (e) => {
        if (!isResizing) return

        const width = startWidth + e.clientX - startX
        const height = startHeight + e.clientY - startY

        if (width > 50 && height > 30) {
            img.style.width = width + 'px'
            img.style.height = height + 'px'
        }
    })

    document.addEventListener('mouseup', () => {
        isResizing = false
    })

    return container
}

const insertImageElement = (src) => {
    const selection = window.getSelection()
    const range = selection.getRangeAt(0)

    const imageContainer = createResizableImage(src)

    range.deleteContents()
    range.insertNode(imageContainer)

    // Move cursor after the image
    range.setStartAfter(imageContainer)
    range.setEndAfter(imageContainer)
    selection.removeAllRanges()
    selection.addRange(range)

    editor.value.focus()
    handleInput()
}

const handleImageUpload = async (event) => {
    const file = event.target.files[0]
    if (!file) return

    try {
        const formData = new FormData()
        formData.append('image', file)

        const response = await fetch(props.uploadUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })

        if (!response.ok) {
            throw new Error('Upload failed')
        }

        const data = await response.json()
        insertImageElement(data.url)
    } catch (error) {
        console.error('Image upload failed:', error)
        // Fallback to data URL for demo purposes
        const reader = new FileReader()
        reader.onload = (e) => {
            insertImageElement(e.target.result)
        }
        reader.readAsDataURL(file)
    }

    // Clear the input
    event.target.value = ''
}

const handlePaste = async (event) => {
    const items = Array.from(event.clipboardData?.items || [])
    const imageItem = items.find(item => item.type.startsWith('image/'))

    if (imageItem) {
        event.preventDefault()

        const file = imageItem.getAsFile()
        if (file) {
            try {
                const formData = new FormData()
                formData.append('image', file)

                const response = await fetch(props.uploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })

                if (!response.ok) {
                    throw new Error('Upload failed')
                }

                const data = await response.json()
                insertImageElement(data.url)
            } catch (error) {
                console.error('Image upload failed:', error)
                // Fallback to data URL
                const reader = new FileReader()
                reader.onload = (e) => {
                    insertImageElement(e.target.result)
                }
                reader.readAsDataURL(file)
            }
        }
    }
}

const handleKeydown = (event) => {
    // Handle common shortcuts
    if (event.ctrlKey || event.metaKey) {
        switch (event.key.toLowerCase()) {
            case 'b':
                event.preventDefault()
                execCommand('bold')
                break
            case 'i':
                event.preventDefault()
                execCommand('italic')
                break
            case 'u':
                event.preventDefault()
                execCommand('underline')
                break
            case 'z':
                if (event.shiftKey) {
                    event.preventDefault()
                    execCommand('redo')
                } else {
                    event.preventDefault()
                    execCommand('undo')
                }
                break
        }
    }
}
</script>

<style scoped>
.rich-editor {
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.toolbar {
    display: flex;
    align-items: center;
    gap: 2px;
    padding: 8px;
    background: #f8f9fa;
    border-bottom: 1px solid #ddd;
    flex-wrap: wrap;
}

.toolbar button {
    padding: 6px 10px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 3px;
    cursor: pointer;
    font-size: 12px;
    min-width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toolbar button:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.toolbar button.active {
    background: #007cba;
    color: white;
    border-color: #0056b3;
}

.separator {
    width: 1px;
    height: 20px;
    background: #ddd;
    margin: 0 4px;
}

.format-select,
.font-select,
.size-select {
    padding: 4px 6px;
    border: 1px solid #ddd;
    border-radius: 3px;
    background: white;
    font-size: 12px;
    height: 28px;
}

.format-select {
    width: 90px;
}

.font-select {
    width: 100px;
}

.size-select {
    width: 60px;
}

.color-input {
    width: 28px;
    height: 28px;
    border: 1px solid #ddd;
    border-radius: 3px;
    padding: 1px;
    cursor: pointer;
    background: white;
}

.editor-content {
    min-height: 300px;
    padding: 12px;
    outline: none;
    line-height: 1.5;
    font-size: 14px;
}

.editor-content:focus {
    box-shadow: inset 0 0 0 2px rgba(0, 124, 186, 0.2);
}

/* Image container styles */
.editor-content :deep(.image-container) {
    display: inline-block;
    position: relative;
    max-width: 100%;
    margin: 5px;
    border: 2px dashed transparent;
}

.editor-content :deep(.image-container:hover) {
    border-color: #007cba;
}

.editor-content :deep(.resize-handle) {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 10px;
    height: 10px;
    background: #007cba;
    cursor: se-resize;
    display: none;
}

.editor-content :deep(.image-container:hover .resize-handle) {
    display: block;
}

.editor-content :deep(img) {
    max-width: 100%;
    height: auto;
    display: block;
}

/* List styles */
.editor-content :deep(ul),
.editor-content :deep(ol) {
    margin: 1em 0;
    padding-left: 2em;
}

.editor-content :deep(blockquote) {
    margin: 1em 0;
    padding-left: 1em;
    border-left: 3px solid #ddd;
    color: #666;
}

.editor-content :deep(h1),
.editor-content :deep(h2),
.editor-content :deep(h3),
.editor-content :deep(h4),
.editor-content :deep(h5),
.editor-content :deep(h6) {
    margin: 0.5em 0;
    font-weight: bold;
}

.editor-content :deep(h1) { font-size: 2em; }
.editor-content :deep(h2) { font-size: 1.5em; }
.editor-content :deep(h3) { font-size: 1.17em; }
.editor-content :deep(h4) { font-size: 1em; }
.editor-content :deep(h5) { font-size: 0.83em; }
.editor-content :deep(h6) { font-size: 0.67em; }

.editor-content :deep(hr) {
    border: none;
    border-top: 1px solid #ddd;
    margin: 1em 0;
}

.editor-content :deep(a) {
    color: #007cba;
    text-decoration: underline;
}

.editor-content :deep(a:hover) {
    text-decoration: none;
}
</style>
