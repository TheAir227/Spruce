
    <!-- Регистрация -->
    <div class="container">
            <form action="actions/signin.php" method="POST" class="form">
                <h2>Авторизация</h2>
                <input type="email" name="email" placeholder="Почта">
                <input type="password" name="password" placeholder="Пароль">
                    <input type="submit" name="signin" class="btn" value="Войти">
                    <?php 
                    if(isset($_SESSION['errors'])){
                        foreach($_SESSION['errors'] as $error){
                            echo '<div class="modal_error">' . $error . '</div>';
                            unset($_SESSION['errors']);
                            break;
                        }
                    }
                    ?>
                    <p>Еще нет аккаунта? <br> <a href="?page=registration">зарегистрироватся</a></p>
            </form>
        </div>
    <!-- Регистрация -->