// resources/js/studio/studio.js

import { Livewire, Alpine } from '../../../vendor/livewire/livewire/dist/livewire.esm'

window.Alpine = Alpine

Alpine.data('studio', (initialState = {}) => ({
    activePage: initialState.activePage ?? '',
    activeSection: initialState.activeSection ?? null,
    activeWidget: initialState.activeWidget ?? null,
    activePanel: initialState.activePanel ?? 'pages',

    togglePanel(panel) {
        this.activePanel = this.activePanel === panel ? '' : panel
    },

    selectPage(pageId) {
        this.activePage = pageId
        this.activeSection = null
        this.activeWidget = null
        this.activePanel = ''

        this.$wire.selectPage(pageId)
    },

    selectSection(sectionId) {
        this.activeSection = sectionId
        this.activeWidget = null
        this.activePanel = ''

        this.$wire.selectSection(sectionId)
    },

    selectWidget(widgetId) {
        this.activeWidget = widgetId
        this.activePanel = 'widgets'

        this.$wire.selectWidget(widgetId)
    },
}))

Livewire.start()

