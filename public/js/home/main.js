const plantillaStandHTML = `<a href="javascript:void(0)" data-mapa="enlace"><div class="contain-caj" style="overflow: hidden;width: 33vh;height: auto;background-color: #fff;padding: 1%;border-radius: 2vh;flex-direction: column;">
    <div class="caja" data-aos="fade-in" style="transition: all 0.3s ease; border: 1px solid #999; height: auto; width: 100%; display: flex; flex-direction: column;">
        <div class="logos-top" style="display: flex; flex-direction: row; align-items: center; width: 100%; padding-top: 3%; padding-bottom: 3%;">
            <span style="background-color: #555faa; padding: 3%; width: 50%; color: #fff; border-radius: 0 7px 7px 0px; font-size: 0.75em; margin-right: 5%;" data-mapa="distrito"></span>
            <img style="width: 40%; color: #fff;" data-mapa="empresa_logo" src="" />
        </div>
        <div>
            <div class="back-standi" style="height: auto;padding: 3%;width: 100%;display: flex;flex-direction: column;background-image: url(https://centrovirtualdeconvenciones.com/portal/imagenes/back-audi.jpg);background-size: cover;background-position: center;align-items: center;">
                <div class="agent" style="margin-top: 2%;margin-bottom: 2%;width: 90%;border-radius: 1.2vh;display: flex;flex-direction: column;background: rgb(77, 84, 94, 0.7);padding: 2%;align-items: center;">
                    <h2 style="display: flex;text-decoration: none;width: 100%;height: auto;flex-direction: row;align-items: center;justify-content: center;font-size: 0.6em;font-weight: 400;color: #fff;margin-top: 0.5%;padding-top: 0.5%;padding-bottom: 0.5%;padding: 2%;margin-bottom: 0.5%;">
                        <span style="display: flex; width: 10px; height: 10px; margin-right: 3%; border-radius: 50%; background-color: #85ae3f;"></span>ASESOR EN LINEA
                    </h2>
                    <div class="box-dat" style="display: flex; width: 100%; flex-direction: row;">
                        <div class="foto" style="display: flex; width: 30%; flex-direction: column; align-items: center; border-radius: 14px; overflow: hidden;">
                            <img style="display: flex; width: 100%;" data-mapa="expositor_foto" src="" />
                        </div>
                        <div class="botones" style="display: flex; width: 65%; margin-left: 5%; flex-direction: row; align-items: center;">
                            <span style="width: 32%; margin-left: 1%; margin-right: 1%;"> <img style="width: 80%;" src="imagenes/icons-call-agent-01.svg" /></span>
                            <span style="width: 32%; margin-left: 1%; margin-right: 1%;"> <img style="width: 80%;" src="imagenes/icons-call-agent-02.svg" /></span>
                            <span style="width: 32%; margin-left: 1%; margin-right: 1%;"> <img style="width: 80%;" src="imagenes/icons-call-agent-03.svg" /></span>
                        </div>
                    </div>
                </div>
                <div class="back" style="width: 100%;position: relative;display: flex;align-items: center;justify-content: center;">
                    <div class="logos-top-stand" style="position: absolute;top: 14%;width: 80%;z-index: 10000;display: flex;flex-direction: row;">
                        <div class="der" style="width: 30%; margin-top: 6.3%;">
                            <img style="width: 100%;" data-mapa="friso_imagen_izquierda" src="" />
                        </div>
                        <div class="space-stand" style="width: 13%;"></div>
                        <div class="right" style="width: 53%; margin-top: 0.4%;">
                            <img style="width: 100%;" data-mapa="friso_imagen_derecha" src="" />
                        </div>
                    </div>
                    <div class="arte-stand-portal" style="position: absolute;top: 43%;left: 17%;width: 62%;z-index: 10000;display: flex;flex-direction: row;">
                        <img style="width: 100%;display: flex;" data-mapa="banner_centro" src=""/>
                    </div>
                    <div class="stand-portal" style="height: auto;width: 100%;display: flex;flex-direction: column;align-items: center;position: relative;">
                        <img style="height: auto;width: 90%;display: flex;flex-direction: column;align-items: center;" src="imagenes/stand-portal.png" />
                    </div>
                </div>
            </div>
        </div>
        <div class="desc" style="height: auto; background-color: #fff; padding: 6%; color: #555; display: flex; flex-direction: column; width: 100%;">
            <div class="textos" style="height: auto; width: 100%; display: flex; justify-content: center; flex-direction: column;">
                <big style="font-weight: 700; font-size: 0.82em; margin: 0px;" data-mapa="titulo"></big>
                <span style="font-weight: 500; font-size: 0.7em; margin: 0px;" data-mapa="descripcion"></span>
            </div>
            <div class="textos-2" style="height: auto; width: 100%; display: flex; padding: 2%; margin-bottom: 0%; flex-direction: row; align-items: center; margin-top: 0%;">
                <span style="font-weight: 500; font-size: 0.7em; color: #e52525; display: flex; width: 40%; align-items: center;">Precio desde</span>
                <strong style="width: 20%;"></strong>
                <big style="font-weight: 700; font-size: 0.96em; margin: 0px; color: #e52525; display: flex; width: 40%; align-items: center;" data-mapa="precio_desde"></big>
            </div>
            <div class="textos-3" style="height: auto; width: 100%; display: flex; border: 2px solid #99c640; flex-direction: row; padding: 2%; align-items: center; border-radius: 20px; margin-top: 0%;">
                <span style="font-weight: 500; font-size: 0.6em; color: #e52525; display: flex; float: left; color: #99c640; width: 40%; align-items: center;">Precio Especial</span>
                <img style="width: 15%;" data-mapa="precio_especial_logo" src="" />
                <strong style="width: 5%;"></strong>
                <big style="font-weight: 700; color: #99c640; font-size: 0.96em; margin: 0px; color: #e52525; display: flex; float: right; align-items: center; width: 40%;" data-mapa="precio_especial"></big>
            </div>
        </div>
    </div>
</div></a>`;

$(document).ready(function() {
    //code
})