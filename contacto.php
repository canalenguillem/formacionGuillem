<?php include 'header.php'; ?>
<h2>Contacto</h2>
<?php
    if(isset($_GET['status'])){
        $status=$_GET['status'];
        $msg=$_GET['msg'];

        ?>
        <div class="contenedor result-save">
            <div class="msg <?=$status?>"><?=$msg?></div>
        </div>
        <?php
    }
?>
<section>
        <form class="formulario" action="savecontact.php" method="POST">
          <fieldset>
            <legend>Contáctame enviando tus datos</legend>
            <div class="contenedor-campos">
                <div class="campo">
                  <label for="nombre">Nombre</label>
                  <input class="input-text" type="text" name="nombre" placeholder="Tu Nombre" />
                </div>
                <div class="campo">
                  <label for="">Teléfono:</label>
                  <input class="input-text" type="tel" name="telefono" placeholder="Tu teléfono" required/>
                </div>
    
                <div class="campo">
                  <label for="">Correo:</label>
                  <input class="input-text" type="email" name="correo" placeholder="Tu email" required />
                </div>
    
                <div class="campo">
                  <label for="">Mensaje:</label>
                  <textarea class="input-text" name="Mensaje" id="" cols="30" rows="10" required></textarea>
                </div>
    
            </div><!--final contenedor campos-->
                <div>
                  <input class="boton w-sm-100 flex alinear-derecha" type="submit" value="Envia" />
                </div>
          </fieldset>
        </form>
      </section>

<?php include 'footer.php'; ?>
