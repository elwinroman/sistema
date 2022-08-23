// Funciones de utilidad
export default {
    animation: {
        /**
         * Animación Collapse
         * @param {HTMLElement} element
         * @param {Number}      duration 
         */
        collapse: function(element, duration = 200) {
            if(document.body.contains(element)) {
                element.style.height = 0;
                element.style.transitionDuration = duration + 'ms';
            }
        },

        /**
         * Animación Expand
         * @param {HTMLElement} element
         * @param {Number}      duration 
         */
        expand: function(element, duration = 200) {
            if(document.body.contains(element)) {
                var sectionHeight = element.scrollHeight;
                element.style.height = sectionHeight + 'px';
                element.style.transitionDuration = duration + 'ms';
            }
        }
    },
    
    // retorna la posición del elemento
    getOffset: function(element) {
        const rect = element.getBoundingClientRect();
        return {
            left: rect.left,
            top: rect.top
        };
    }
}
