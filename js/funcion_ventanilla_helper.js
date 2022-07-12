class helperVentanilla {

    obtenerActaEspecifica (pila, tipo_acta) {
        let lista_acta_filtrado = [];
        if (this.isJSON(pila[0].seguimiento)) {
            let seguimiento_json = JSON.parse(pila[0].seguimiento);
            let lista_acta = seguimiento_json.pila_acta;
            lista_acta_filtrado =  lista_acta.filter( (item) =>  parseInt(item.tipo) === parseInt(tipo_acta));
        }
        return lista_acta_filtrado;
    }

    showPdfInNewTab(base64Data, fileName) {
        let pdfWindow = window.open("");
        pdfWindow.document.write("<html<head><title>"+fileName+"</title><style>body{margin: 0px;}iframe{border-width: 0px;}</style></head>");
        pdfWindow.document.write("<body><embed width='100%' height='100%' src='data:application/pdf;base64, " + encodeURI(base64Data) + "#scrollable=0'></embed></body></html>");
    }

    isJSON(text) {
        if (typeof text !== "string") {
            return false;
        }
        try {
            var json = JSON.parse(text);
            return (typeof json === 'object');
        } catch (error) {
            return false;
        }
    }

    formularioValido (form) {
        form.validate({
            errorElement: 'span',
            errorClass: 'text-danger',
            errorPlacement: function(error, element) {
                element.attr("name") === "archivo"
                    ? error.appendTo('form#'+ form[0].id + ' #error_archivo')
                    : error.insertAfter(element)
            },
            rules: {
                archivo: {
                    required: true,
                    extension: "pdf",
                    filesize: 5 // 5MB
                }
            }
        })
        return form.valid()
    }

    pathSite () {
        switch (document.location.hostname) {
            case 'turismo.test':
            case 'ventanilla.test':
            case 'prestadores.test':
            case 'prestadores.plataformasecturchiapas.com':
            case 'prestadores.plataformasecturchiapas.mx': return ''
            default : return '/turismo'
        }
    }

    pathFile () {
        switch (document.location.hostname) {
            case 'ventanilla.test':
            case 'prestadores.test': return 'http://turismo.test'
            case 'turismo.test': return ''
            case 'prestadores.plataformasecturchiapas.com':
            case 'prestadores.plataformasecturchiapas.mx': return 'https://plataformasecturchiapas.mx/turismo'
            default : return '/turismo'
        }
    }

}