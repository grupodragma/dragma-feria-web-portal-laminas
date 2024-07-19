let Panel = {
    idioma: '',
    sesionUsuario: '',
    windowObjectReference: null,
    idPlanoCotizarAhora: null,
    init: function(){
        this.sesionUsuario = ( this.sesionUsuario === '1' ) ? true : false;
    },
    cambiarIdioma: function(obj){
        let idioma = $(obj).val();
        let idiomaUrl = '/'+idioma+'/';
        let url = this.getUrlIdioma(idioma, idiomaUrl);
        let urlRedirect = ( window.location.pathname === '/' ) ? url+idioma : url;
        window.location.href = urlRedirect;
    },
    getUrlIdioma(idioma, idiomaUrl){
        let idiomaIndex = '/'+idioma; 
        let url = '';
        if(window.location.pathname === '/'){
            url = window.location.href.replace('/es', idiomaUrl).replace('/en', idiomaUrl).replace('/pt', idiomaUrl).replace('/zh', idiomaUrl);
        } else {
            if(['/es','/en','/pt','/zh'].indexOf(window.location.pathname) !== -1){
                url = window.location.href.replace('/es', idiomaIndex).replace('/en', idiomaIndex).replace('/pt', idiomaIndex).replace('/zh', idiomaIndex);
            } else {
                url = window.location.href.replace('/es/', idiomaUrl).replace('/en/', idiomaUrl).replace('/pt/', idiomaUrl).replace('/zh/', idiomaUrl);
            }
        }
        return url;
    },
    enviarCorreo: function(accion, id, obj){
        if(this.sesionUsuario){
            $(obj).addClass("disabled");
            $.post(this.idioma+"/panel/enviar-correo", {accion: accion, id: id},function(response){
                if( response.result == "success" ) {
                    alert("Correo enviado correctamente...");
                }
                $(obj).removeClass("disabled");
            }, 'json');
        }
    },
    compartirRedesSociales(app) {
        const configuracion_ventana = "resizable,scrollbars,status";
        const apps = {
            facebook: 'https://www.facebook.com/sharer/sharer.php?u=',
            linkedin: 'https://www.linkedin.com/sharing/share-offsite/?url=',
            whatsapp: 'https://api.whatsapp.com/send/?phone&app_absent=0&text='
        }
        if(typeof apps[app] === 'undefined')return;
        this.windowObjectReference = window.open(`${apps[app]}${window.location.href}`, "Compartir Eventos", configuracion_ventana);
    }
}

let Buscador = {
    filtrosSeleccionados: new Object(),
    filtrar: function(){
        console.log('Filtrar proyectos')
        let params = [];
        document.querySelectorAll(".all-selecters select").forEach(function(obj){
            let keySelect = obj.getAttribute("data-filtro");
            let valueSelect = obj.value;
            params.push(`${keySelect}=${valueSelect}`)
        })
        window.location.href = `/${Panel.idioma}/panel/busqueda-proyectos?${params.join("&")}`
    },
    fijarFiltrosSeleccionados: function(){
        let _this = this;
        if(Object.keys(_this.filtrosSeleccionados).length){
            document.querySelectorAll(".all-selecters select").forEach(function(objSelect){
                let keySelect = objSelect.getAttribute("data-filtro");
                if( typeof _this.filtrosSeleccionados[keySelect] !== "undefined" && _this.filtrosSeleccionados[keySelect] != "" ){
                    objSelect.value = _this.filtrosSeleccionados[keySelect];
                }
            })
        }
    }
}