// Funciones de utilidad
export default {
    animation: {
        collapse: function(element) {
            if(document.body.contains(element))
                element.style.height = 0;
        },
        expand: function(element) {
            if(document.body.contains(element)) {
                var sectionHeight = element.scrollHeight;
                element.style.height = sectionHeight + "px";
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
