
<!-- Регистрация -->
    <div class="container">
            <form action="actions/signup.php" method="POST" class="form">
                <h2>Регистрация</h2>
                <input type="email" name="email" placeholder="Почта">
                <input type="text" name="name" placeholder="Имя">
                <input type="text" name="surname" placeholder="Фамилия">
                <input type="date" name="date" placeholder="Дата рождения">
                <input type="password" name="password" placeholder="Пароль">
                <input type="password" name="re_password" placeholder="Повтор пароля">
                <div class="label-reg">
                    <input type="checkbox" id="checkbox" required>
                <label for="checkbox">Согласен на обработку
                    персональных данных</label>
                </div>
                    <input type="submit" name="signup" class="btn" value="Зарегистрироватся">

                    <?php 
                    if(isset($_SESSION['errors'])){
                        foreach($_SESSION['errors'] as $error){
                            echo '<div class="modal_error">' . $error . '</div>';
                            unset($_SESSION['errors']);
                            break;
                        }
                    }
                    
                    ?>

                    <p>Уже есть аккаунт? <br> <a href="?page=auth">войти</a></p>
            </form>
        </div>
    <!-- Регистрация -->
    