<?php $this->layout('app:layout'); //var_dump(md5(''));
?>

    <div class="emptyform">
        <div class="uk-vertical-align uk-text-center uk-height-1-1">
            <div class="uk-vertical-align-middle" style="width: 250px;">
                <form class="uk-panel uk-panel-box uk-form" method="post">
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" type="email" placeholder="Email" name="Email" value="<?=$Email?>">
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-1-1 uk-form-large" type="password" placeholder="Password" name="Password" value="<?=$Password?>">
                    </div>
                    <div class="uk-form-row">
                        <button class="uk-width-1-1 uk-button uk-button-primary uk-button-large">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
