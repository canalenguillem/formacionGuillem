<?php include 'header.php'; ?>

    <h1>Iniciar sesión</h1>
    <main>
    <form class="formulario" action="savecontact.php" method="POST">
          <fieldset>
            <legend>Email y password</legend>
            <div class="contenedor-campos">
                <div class="campo">
                  <label for="correo">Email</label>
                  <input class="input-text" type="email" name="email" placeholder="Tu Email" />
                </div>
                <div class="campo">
                  <label for="">Password:</label>
                  <input class="input-text" type="password" name="password" placeholder="Tu Password" required/>
                </div>
    
                <div>
                  <input class="boton w-sm-100 flex alinear-derecha" type="submit" value="Entrar" />
                </div>
          </fieldset>
        </form>
      </section>
    </main>
<?php include 'footer.php'; ?>
