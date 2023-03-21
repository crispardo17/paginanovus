<?php
include("../forms/conexion.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/your-path-to-fontawesome/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/jpg" href="https://i.ibb.co/gPhcmMd/logo-ojo-novus.png">
    <title>Grupo Novus | Legal</title>
    <link href=".././assets/css/style.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="header">
            <div class="header_logo"><a href="../"><img src="https://i.ibb.co/tJHD9tW/logo-gruponovus.png" alt=""></a>
            </div>
            <div class="header-buton"><span class="fa fa-bars fa-3x"></span></div>
        </div>
        <div class="navbar">
            <p class="indice"></p>
            <nav>
                <ul>
                    <li><a data-scroll href="./../about/" rel="noopener noreferrer">nosotros</a></li>
                    <li><a data-scroll href="./../empresarial/" rel="noopener noreferrer">Grupo Empresarial</a></li>
                    <li><a data-scroll href="./../noticias/" rel="noopener noreferrer">Noticias</a></li>
                    <li><a data-scroll href="#contacto-gruponovus" rel="noopener noreferrer">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="legal-solicitud">
        <section class="legal-solicitud-fondo">
            <div class="legals__titulo-solicitud">
                <p>
                    <img class="icon-solicitud" src="https://i.ibb.co/Hq1RRTf/Logo-Novus-Legal-09.png">&nbsp &nbsp<b>SOLICITUD</b> ESTUDIO DE TÍTULO
                </p>
                <form id="form-solicitud" method="post" action="../forms/infoLegal.php">
                    <div class="legal-grid-form">
                        <div class="solicitud-f">
                            <label for="nombre">Nombres:</label>
                            <input type="text" id="nombre" name="nombres" required>
                            <label for="nombre">Apellidos:</label>
                            <input type="text" id="apellido" name="apellidos" required>
                            <label for="tipo">Tipo de Documento:</label>
                            <select name="tipoDocumentoId" id="tipoDocumentoId" required>
                                <option value=""></option>
                                <?php
                                $documento = getTipoDocumento($conn);
                                foreach ($documento as $row) {
                                ?>
                                    <option value="<?php echo $row["tipoDocumentoId"] ?>"><?php echo $row["nombre"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="documento">Número de Documento:</label>
                            <input type="text" id="documentoCliente" name="documentoCliente" required>
                            <label for="correo">Correo:</label>
                            <input type="mail" id="correoElectronico" name="correoElectronico" required>
                            <label for="telefono">Telefono:</label>
                            <input type="number" id="celular1" name="celular1" required>
                        </div>
                        <div class="solicitud-f">
                            <label class="matriculas" for="matriculas">Matrícula Inmueble:</label>
                            <input type="text" id="matricula" name="matricula">
                            <div id="divDireccion">
                                <label for="inmueble">Dirección Inmueble:</label>
                                <input type="text" id="inmueble" name="inmueble">
                            </div>
                            <div id="divSelectDireccion">
                                <label for="tipo">Direccion inmueble:</label>
                                <select name="selectDireccion" id="selectDireccion">
                                    <option value="0"> Direccion Diferente</option>
                                </select>
                            </div>
                            <label for="tipoInmueble">Tipo inmueble:</label>
                            <select name="tipoInmueble" id="tipoInmueble">
                                <option value=""></option>
                                <?php
                                $inmueble = getTipoInmueble($conn);
                                foreach ($inmueble as $row) {
                                ?>
                                    <option value="<?php echo $row["tipoInmuebleId"] ?>"><?php echo $row["nombre"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="city">Ciudad inmueble:</label>
                            <select name="ciudad" id="ciudad">
                                <option value=""></option>
                                <?php
                                $ciudad = getTipoCiudad($conn);
                                foreach ($ciudad as $row) {
                                ?>
                                    <option value="<?php echo $row["ciudadId"] ?>"><?php echo $row["nombre"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="comercial">Avalúo Comercial:</label>
                            <input type="text" id="comercial" name="comercial">
                            <label for="entidad">Entidad:</label>
                            <select name="entidad" id="entidad">
                                <option value=""></option>
                                <?php
                                $entidad = getEntidad($conn);
                                foreach ($entidad as $row) {
                                ?>
                                    <option value="<?php echo $row["entidadBancariaId"] ?>"><?php echo $row["nombre"] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <label for="proceso">N° Proceso de la Entidad:</label>
                            <input type="text" id="proceso" name="proceso">
                            <button class="agregar" id="btn-agregar" title="" name="btn-agregar" type="button" onclick="agregarTbl(matricula, inmueble, tipoInmueble, ciudad, comercial, entidad, proceso);">Agregar</button>
                        </div>
                        <div class="solicitud-f" id="tblSolicitud" name="tblSolicitud">
                            <table id="tblAgregar" name="tblAgregar">
                                <thead>
                                    <th>Matricula inmueble</th>
                                    <th>Dirección Inmbueble</th>
                                    <th>Tipo de Inmueble</th>
                                    <th>Ciudad</th>
                                    <th>Avalúo Comercial</th>
                                    <th>Entidad</th>
                                    <th>N° Proceso de la Entidad</th>
                                    <th>Acción</th>
                                </thead>
                                <tbody id="tblBodyAgregar" name="tblBodyAgregar">
                                </tbody>
                            </table>
                        </div>
                        <div class="solicitud-f">
                            <input type="checkbox" id="btn-modal" required>
                            <label for="btn-modal" id="text-modal" class="lbl-modal" onclick="modalToggle('terminos','btn-modal')"> Acepto los términos y
                                condiciones.</label>
                            <div class="modal" id="terminos">
                                <div class="contenedor">
                                    <div class="head-modal">
                                        <label for="btn-modal" onclick="modalToggle('terminos','btn-modal')">X</label>
                                        <h1>TÉRMINOS Y<br> CONDICIONES</h1>
                                        <img class="icon-modal" src="https://i.ibb.co/qBFL7xw/Logo-Novus-Legal-14.png"">
                                    </div>
                                    <div class=" contenido">
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora recusandae hic id tenetur, nobis impedit consequatur molestiae nam velit magnam optio numquam inventore aliquam doloribus aperiam rerum! Quibusdam, vero enim.
                                            Sapiente, porro. Voluptatibus repellendus eligendi quaerat velit aliquam iure, temporibus explicabo quas. Hic cupiditate excepturi dolorum, in quaerat perferendis similique culpa voluptas at, quis ad velit alias natus dolor illum!
                                            Eius vel numquam, velit soluta a ea dolor ad illo asperiores corrupti repellendus error laudantium sequi ducimus ex architecto hic animi placeat voluptate. Harum sed nulla eveniet, explicabo perferendis molestiae.
                                            Vero incidunt officia, in quasi non eum vel dignissimos fugit voluptatem voluptate aut ex culpa harum animi possimus enim quia at neque quas? Facilis asperiores, maxime itaque a dolores neque.
                                            Accusamus deserunt temporibus, voluptates libero quae distinctio? Repellendus eum est, corrupti tenetur voluptatum reiciendis recusandae. Veniam delectus architecto labore cupiditate maxime ad repellendus voluptate numquam aliquid eius ipsum, porro deserunt!
                                            Aspernatur a ipsum qui labore voluptatibus, fuga autem nihil iusto nemo ex quis beatae eligendi perferendis voluptas exercitationem sit quae blanditiis nisi optio maxime temporibus. Ipsum deleniti repudiandae veniam beatae.
                                            Aut fugiat eos quos dignissimos architecto tempore aliquam consequuntur doloremque recusandae quae, corporis sequi, sit minus amet ducimus quas nulla, esse ratione eum dolorum delectus? At dolore magni pariatur similique.
                                            Rerum, ipsam tempora totam architecto ipsa libero sint maiores excepturi nostrum neque voluptatibus. Incidunt sequi quidem quae non nostrum debitis qui. Sunt, temporibus quibusdam aliquid id provident aut eius minus.
                                            Aspernatur cupiditate facere repellat exercitationem dolores dignissimos, laborum ratione dicta? Doloribus voluptatibus reprehenderit animi ullam at labore? Fugit vel quis ad recusandae nemo exercitationem! Ab sit saepe quaerat dolores inventore!
                                            Laborum ex labore maxime dolore! Adipisci quidem odit doloremque voluptas labore nemo cum accusamus facilis sunt rem, illum totam dolorum similique ab, commodi eveniet assumenda modi aliquam. Delectus, similique sapiente.
                                            Temporibus ad commodi minima corrupti alias vel amet, esse repellendus quisquam nulla, saepe, minus necessitatibus totam. Excepturi, beatae blanditiis! Molestiae, optio. Repellendus sapiente tempore ipsa iste animi laudantium, quaerat placeat.
                                            Maiores, repellat dolore nulla veniam ad voluptates optio labore sed maxime rerum rem atque ipsum illum. Sequi animi tempore inventore, deserunt dolorum quibusdam vel, laboriosam enim quae quod asperiores totam.
                                            Consectetur voluptatum consequuntur delectus dolorem, ad reiciendis, maxime rerum quia, blanditiis consequatur voluptates reprehenderit facilis corrupti recusandae? Fugit tempore ratione, beatae iusto molestias incidunt sed ipsam quibusdam cum maxime aliquid.
                                            Fuga dolores obcaecati natus magni sapiente error mollitia ad voluptate iusto animi, minus rerum harum aut laboriosam reiciendis corrupti ut autem. Ad eaque nemo nulla nobis, veritatis dolor non ut!
                                            Exercitationem sit architecto quae sed iste accusantium, nostrum ducimus qui delectus porro inventore vitae suscipit id impedit animi quaerat omnis amet eum laboriosam necessitatibus beatae! Molestiae in id sunt temporibus!
                                            Tempore ipsam totam doloribus sequi. Beatae dolor maiores similique itaque ab pariatur qui, asperiores doloremque cupiditate blanditiis consectetur enim tempora natus voluptatibus illo repudiandae sit deleniti aspernatur eveniet esse. Suscipit.
                                            Dolores rem laudantium ipsum vero quae itaque eum blanditiis, asperiores alias deleniti ex provident nihil amet atque quo hic aut! Molestias quisquam voluptatum nam commodi blanditiis sint distinctio vero ipsum.
                                            Adipisci quod asperiores doloremque consequuntur mollitia natus possimus esse eaque nulla cupiditate! Delectus deserunt sequi minima beatae ducimus quod, aut laudantium alias quae, culpa eveniet repellendus itaque. Ad, doloribus animi.
                                            Ad, repellendus optio odit illo, ipsa possimus quisquam, fugit iure maiores modi ipsam neque! Rem, impedit, in quam eos consequuntur sint quaerat hic enim modi architecto inventore dicta! Explicabo, consequatur?
                                            Possimus hic deleniti at adipisci autem! Doloribus ex laudantium ut nesciunt animi perferendis perspiciatis officia sunt dolorum atque commodi ullam modi, quisquam vitae possimus totam ducimus nulla sint debitis! Fugit!
                                        </p>
                                    </div>
                                    <div class="footer-modal">
                                        <button class="aceptar" id="btn-aceptar" name="btn-aceptar" type="button" onclick="aceptar('terminos','btn-modal')">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="solicitud-f">
                            <input type="checkbox" id="btn-modal-2" required>
                            <label for="btn-modal-2" id="text-modal" class="lbl-modal" onclick="modalToggle('terminos2','btn-modal-2')"> Acepto los términos y <br>
                                condiciones.</label>
                            <div class="modal" id="terminos2">
                                <div class="contenedor">
                                    <div class="head-modal">
                                        <label for="btn-modal-2" onclick="modalToggle('terminos2','btn-modal-2')">X</label>
                                        <h1>TÉRMINOS Y<br> CONDICIONES</h1>
                                        <img class="icon-modal" src="https://i.ibb.co/qBFL7xw/Logo-Novus-Legal-14.png"">
                                </div>
                                <div class=" contenido">
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora recusandae hic id tenetur, nobis impedit consequatur molestiae nam velit magnam optio numquam inventore aliquam doloribus aperiam rerum! Quibusdam, vero enim.
                                            Sapiente, porro. Voluptatibus repellendus eligendi quaerat velit aliquam iure, temporibus explicabo quas. Hic cupiditate excepturi dolorum, in quaerat perferendis similique culpa voluptas at, quis ad velit alias natus dolor illum!
                                            Eius vel numquam, velit soluta a ea dolor ad illo asperiores corrupti repellendus error laudantium sequi ducimus ex architecto hic animi placeat voluptate. Harum sed nulla eveniet, explicabo perferendis molestiae.
                                            Vero incidunt officia, in quasi non eum vel dignissimos fugit voluptatem voluptate aut ex culpa harum animi possimus enim quia at neque quas? Facilis asperiores, maxime itaque a dolores neque.
                                            Accusamus deserunt temporibus, voluptates libero quae distinctio? Repellendus eum est, corrupti tenetur voluptatum reiciendis recusandae. Veniam delectus architecto labore cupiditate maxime ad repellendus voluptate numquam aliquid eius ipsum, porro deserunt!
                                            Aspernatur a ipsum qui labore voluptatibus, fuga autem nihil iusto nemo ex quis beatae eligendi perferendis voluptas exercitationem sit quae blanditiis nisi optio maxime temporibus. Ipsum deleniti repudiandae veniam beatae.
                                            Aut fugiat eos quos dignissimos architecto tempore aliquam consequuntur doloremque recusandae quae, corporis sequi, sit minus amet ducimus quas nulla, esse ratione eum dolorum delectus? At dolore magni pariatur similique.
                                            Rerum, ipsam tempora totam architecto ipsa libero sint maiores excepturi nostrum neque voluptatibus. Incidunt sequi quidem quae non nostrum debitis qui. Sunt, temporibus quibusdam aliquid id provident aut eius minus.
                                            Aspernatur cupiditate facere repellat exercitationem dolores dignissimos, laborum ratione dicta? Doloribus voluptatibus reprehenderit animi ullam at labore? Fugit vel quis ad recusandae nemo exercitationem! Ab sit saepe quaerat dolores inventore!
                                            Laborum ex labore maxime dolore! Adipisci quidem odit doloremque voluptas labore nemo cum accusamus facilis sunt rem, illum totam dolorum similique ab, commodi eveniet assumenda modi aliquam. Delectus, similique sapiente.
                                            Temporibus ad commodi minima corrupti alias vel amet, esse repellendus quisquam nulla, saepe, minus necessitatibus totam. Excepturi, beatae blanditiis! Molestiae, optio. Repellendus sapiente tempore ipsa iste animi laudantium, quaerat placeat.
                                            Maiores, repellat dolore nulla veniam ad voluptates optio labore sed maxime rerum rem atque ipsum illum. Sequi animi tempore inventore, deserunt dolorum quibusdam vel, laboriosam enim quae quod asperiores totam.
                                            Consectetur voluptatum consequuntur delectus dolorem, ad reiciendis, maxime rerum quia, blanditiis consequatur voluptates reprehenderit facilis corrupti recusandae? Fugit tempore ratione, beatae iusto molestias incidunt sed ipsam quibusdam cum maxime aliquid.
                                            Fuga dolores obcaecati natus magni sapiente error mollitia ad voluptate iusto animi, minus rerum harum aut laboriosam reiciendis corrupti ut autem. Ad eaque nemo nulla nobis, veritatis dolor non ut!
                                            Exercitationem sit architecto quae sed iste accusantium, nostrum ducimus qui delectus porro inventore vitae suscipit id impedit animi quaerat omnis amet eum laboriosam necessitatibus beatae! Molestiae in id sunt temporibus!
                                            Tempore ipsam totam doloribus sequi. Beatae dolor maiores similique itaque ab pariatur qui, asperiores doloremque cupiditate blanditiis consectetur enim tempora natus voluptatibus illo repudiandae sit deleniti aspernatur eveniet esse. Suscipit.
                                            Dolores rem laudantium ipsum vero quae itaque eum blanditiis, asperiores alias deleniti ex provident nihil amet atque quo hic aut! Molestias quisquam voluptatum nam commodi blanditiis sint distinctio vero ipsum.
                                            Adipisci quod asperiores doloremque consequuntur mollitia natus possimus esse eaque nulla cupiditate! Delectus deserunt sequi minima beatae ducimus quod, aut laudantium alias quae, culpa eveniet repellendus itaque. Ad, doloribus animi.
                                            Ad, repellendus optio odit illo, ipsa possimus quisquam, fugit iure maiores modi ipsam neque! Rem, impedit, in quam eos consequuntur sint quaerat hic enim modi architecto inventore dicta! Explicabo, consequatur?
                                            Possimus hic deleniti at adipisci autem! Doloribus ex laudantium ut nesciunt animi perferendis perspiciatis officia sunt dolorum atque commodi ullam modi, quisquam vitae possimus totam ducimus nulla sint debitis! Fugit!
                                        </p>
                                    </div>
                                    <div class="footer-modal">
                                        <button class="aceptar" id="btn-aceptar" name="btn-aceptar" type="button" onclick="aceptar('terminos2','btn-modal-2')">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="solicitud-f">
                            <input type="checkbox" id="btn-modal-3" required>
                            <label for="btn-modal-3" id="text-modal" class="lbl-modal" onclick="modalToggle('terminos3','btn-modal-3')"> Acepto los términos y
                                condiciones.</label>
                            <div class="modal" id="terminos3">
                                <div class="contenedor">
                                    <div class="head-modal">
                                        <label for="btn-modal-3" onclick="modalToggle('terminos3','btn-modal-3')">X</label>
                                        <h1>TÉRMINOS Y<br> CONDICIONES</h1>
                                        <img class="icon-modal" src="https://i.ibb.co/qBFL7xw/Logo-Novus-Legal-14.png"">
                                </div>
                                <div class=" contenido">
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora recusandae hic id tenetur, nobis impedit consequatur molestiae nam velit magnam optio numquam inventore aliquam doloribus aperiam rerum! Quibusdam, vero enim.
                                            Sapiente, porro. Voluptatibus repellendus eligendi quaerat velit aliquam iure, temporibus explicabo quas. Hic cupiditate excepturi dolorum, in quaerat perferendis similique culpa voluptas at, quis ad velit alias natus dolor illum!
                                            Eius vel numquam, velit soluta a ea dolor ad illo asperiores corrupti repellendus error laudantium sequi ducimus ex architecto hic animi placeat voluptate. Harum sed nulla eveniet, explicabo perferendis molestiae.
                                            Vero incidunt officia, in quasi non eum vel dignissimos fugit voluptatem voluptate aut ex culpa harum animi possimus enim quia at neque quas? Facilis asperiores, maxime itaque a dolores neque.
                                            Accusamus deserunt temporibus, voluptates libero quae distinctio? Repellendus eum est, corrupti tenetur voluptatum reiciendis recusandae. Veniam delectus architecto labore cupiditate maxime ad repellendus voluptate numquam aliquid eius ipsum, porro deserunt!
                                            Aspernatur a ipsum qui labore voluptatibus, fuga autem nihil iusto nemo ex quis beatae eligendi perferendis voluptas exercitationem sit quae blanditiis nisi optio maxime temporibus. Ipsum deleniti repudiandae veniam beatae.
                                            Aut fugiat eos quos dignissimos architecto tempore aliquam consequuntur doloremque recusandae quae, corporis sequi, sit minus amet ducimus quas nulla, esse ratione eum dolorum delectus? At dolore magni pariatur similique.
                                            Rerum, ipsam tempora totam architecto ipsa libero sint maiores excepturi nostrum neque voluptatibus. Incidunt sequi quidem quae non nostrum debitis qui. Sunt, temporibus quibusdam aliquid id provident aut eius minus.
                                            Aspernatur cupiditate facere repellat exercitationem dolores dignissimos, laborum ratione dicta? Doloribus voluptatibus reprehenderit animi ullam at labore? Fugit vel quis ad recusandae nemo exercitationem! Ab sit saepe quaerat dolores inventore!
                                            Laborum ex labore maxime dolore! Adipisci quidem odit doloremque voluptas labore nemo cum accusamus facilis sunt rem, illum totam dolorum similique ab, commodi eveniet assumenda modi aliquam. Delectus, similique sapiente.
                                            Temporibus ad commodi minima corrupti alias vel amet, esse repellendus quisquam nulla, saepe, minus necessitatibus totam. Excepturi, beatae blanditiis! Molestiae, optio. Repellendus sapiente tempore ipsa iste animi laudantium, quaerat placeat.
                                            Maiores, repellat dolore nulla veniam ad voluptates optio labore sed maxime rerum rem atque ipsum illum. Sequi animi tempore inventore, deserunt dolorum quibusdam vel, laboriosam enim quae quod asperiores totam.
                                            Consectetur voluptatum consequuntur delectus dolorem, ad reiciendis, maxime rerum quia, blanditiis consequatur voluptates reprehenderit facilis corrupti recusandae? Fugit tempore ratione, beatae iusto molestias incidunt sed ipsam quibusdam cum maxime aliquid.
                                            Fuga dolores obcaecati natus magni sapiente error mollitia ad voluptate iusto animi, minus rerum harum aut laboriosam reiciendis corrupti ut autem. Ad eaque nemo nulla nobis, veritatis dolor non ut!
                                            Exercitationem sit architecto quae sed iste accusantium, nostrum ducimus qui delectus porro inventore vitae suscipit id impedit animi quaerat omnis amet eum laboriosam necessitatibus beatae! Molestiae in id sunt temporibus!
                                            Tempore ipsam totam doloribus sequi. Beatae dolor maiores similique itaque ab pariatur qui, asperiores doloremque cupiditate blanditiis consectetur enim tempora natus voluptatibus illo repudiandae sit deleniti aspernatur eveniet esse. Suscipit.
                                            Dolores rem laudantium ipsum vero quae itaque eum blanditiis, asperiores alias deleniti ex provident nihil amet atque quo hic aut! Molestias quisquam voluptatum nam commodi blanditiis sint distinctio vero ipsum.
                                            Adipisci quod asperiores doloremque consequuntur mollitia natus possimus esse eaque nulla cupiditate! Delectus deserunt sequi minima beatae ducimus quod, aut laudantium alias quae, culpa eveniet repellendus itaque. Ad, doloribus animi.
                                            Ad, repellendus optio odit illo, ipsa possimus quisquam, fugit iure maiores modi ipsam neque! Rem, impedit, in quam eos consequuntur sint quaerat hic enim modi architecto inventore dicta! Explicabo, consequatur?
                                            Possimus hic deleniti at adipisci autem! Doloribus ex laudantium ut nesciunt animi perferendis perspiciatis officia sunt dolorum atque commodi ullam modi, quisquam vitae possimus totam ducimus nulla sint debitis! Fugit!
                                        </p>
                                    </div>
                                    <div class="footer-modal">
                                        <button class="aceptar" id="btn-aceptar" name="btn-aceptar" type="button" onclick="aceptar('terminos3','btn-modal-3')">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="solicitud-f">
                            <button class="siguiente" type="submit">Siguiente</button><br>
                        </div>
                        <div class="solicitud-f">
                            <img class="icon-footer-solicitud" src="https://i.ibb.co/3myQvbW/Logo-Novus-Legal-17.png">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../app.bundle.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#divSelectDireccion').hide();
            $('#tblSolicitud').hide();
        });

        function modalToggle(modal, check) {
            console.log($("#" + check).prop("checked"));
            $("#" + check).prop('checked', true);
            $("#" + modal).fadeToggle(100);
        }

        function aceptar(modal, check) {

            $("#" + modal).fadeToggle(100);
            $("#" + check).prop("checked", true);
        }

        let j = 1;
        let dif = 0;
        let arrayDireccion = [];
        let arrayDireccionCopy = [];
        let tabla = {};
        

        function agregarTbl(matricula, inmueble, tipoInmueble, ciudad, comercial, entidad, proceso, negocio) {
            if (matricula.value != "" && inmueble.value != "" && tipoInmueble.value != "" && ciudad.value != "" &&
                comercial.value != "" && entidad.value != "" && proceso.value != "") {

                let fila = {
                    "matricula": matricula.value,
                    "inmueble": inmueble.value,
                    "tipoInmueble": tipoInmueble.value,
                    "tipoInmuebletext": $('#tipoInmueble option:selected').html(),
                    "ciudad": ciudad.value,
                    "ciudadtext": $('#ciudad option:selected').html(),
                    "comercial": comercial.value,
                    "entidad": entidad.value,
                    "entidadtext": $('#entidad option:selected').html(),
                    "proceso": proceso.value
                };

                if (!tabla[inmueble.value]) {
                    tabla[inmueble.value] = [];
                    tabla[inmueble.value].push(fila)
                } else {

                    tabla[inmueble.value].push(fila)
                   
                }



                cargarTabla();

                arrayDireccion.map((element) => {
                    if (element != inmueble) {
                        arrayDireccionCopy.push(inmueble);
                    }
                });
                arrayDireccion = arrayDireccionCopy;
                $('#divDireccion').hide();

                let select = $('#selectDireccion');
                let option = `<option type='hidden' value='${inmueble.value}'>${inmueble.value}</option>`;
                select.append(option);
                $('#divSelectDireccion').show();
                select.val('');
            } else {
                Swal.fire('Faltan datos por agregar')
            }
        }

        function cargarTabla() {
            let tbl = $('#tblAgregar');
            let tblBody = $('#tblBodyAgregar');
            tblBody.html("");
        
                Object.keys(tabla).forEach((index) => {
                    tabla[index].map((fila) => {
                        filaTabla =
                            `<tr><td>  <input name='num-matricula${j}' type='hidden' value='${fila.matricula}'> ${fila.matricula}` +
                            `</td><td> <input type='hidden' name='inmueble${j}' value='${fila.inmueble}'> ${fila.inmueble}` +
                            `</td><td> <input type='hidden' name='tipoInmueble${j}' value='${fila.tipoInmueble}'> ${fila.tipoInmuebletext}` +
                            `</td><td> <input type='hidden' name='ciudad${j}' value='${fila.ciudad}'> ${fila.ciudadtext}` +
                            `</td><td> <input type='hidden' name='a-comercial${j}' value='${fila.comercial}'> ${fila.comercial}` +
                            `</td><td> <input type='hidden' name='entidad${j}' value='${fila.entidad}'> ${fila.entidadtext}` +
                            `</td><td> <input type='hidden' name='n-proceso${j}' value='${fila.proceso}'> ${fila.proceso}` +
                            `</td><td> <button type='button' name='eliminar${j}' value="eliminar" onclick="eliminar('${index}','${fila.matricula}')"
    class="btn btn-danger"><i class="fa fa-trash"></i></button> </td></tr>`;

                        tblBody.append(filaTabla);
                        j++;
                        tblBody.append(`<input type='hidden' name='tabla' value='${JSON.stringify(tabla)}'>`);
                        $('#tblSolicitud').show();
                    })
                });
            
        }

        function eliminar(index,fila) {
          

           

            var d = index;
            Swal.fire({
                title: 'Estas Seguro?',
                text: "No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire
                    mat=tabla[index].find(element => element.matricula==fila);
                    tabla[index].splice(tabla[index].indexOf(mat),1);
                    if(tabla[index].length==0){

                        delete(tabla[index]);
                    }
                    cargarTabla();
                    (
                        'Eliminado!',
                        'Tus datos fueron eliminador.',
                        'success'
                    )
                }
            })
        }

        $("#selectDireccion").change(function() {
            console.log(this);
            if (this.value == 0) {
                $('#divSelectDireccion').hide();
                $('#divDireccion').show();
                $('#inmueble').attr("disabled", false);
                $('#inmueble').val('');
                dif = 1;
            } else {
                dif = 0;
                let direccion = this.value;

                $('#inmueble').val(direccion);
                $('#inmueble').attr("disabled", true);
                $('#divDireccion').show();
                $('#divSelectDireccion').hide();
            }
        });


        $(document).ready(function() {
            $('#btn-agregar').click(function() {
                $('input[name="matricula"]').val('');
                $('select[name="tipoInmueble"]').val('');
                $('select[name="ciudad"]').val('');
                $('input[name="comercial"]').val('');
                $('select[name="entidad"]').val('');
                $('input[name="proceso"]').val('');
            });

        });
    </script>


</body>

</html>