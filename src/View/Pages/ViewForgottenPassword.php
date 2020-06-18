<?php $this->_title = 'MDP'; ?>

<h1>Réinitialisation du Mot de passe</h1>
<?php if (isset($form)): ?>
    <div>
        Veuillez Saisir votre email, vous recevrez les instructions de
        réinitialisation du mot de passe dans votre boite mail
    </div>
    <form action="index.php?url=password" method="POST">
        <div class="field">
            <label class="label has-text-danger">Email</label>
            <div class="control">
                <input name="email" class="input" type="text" placeholder="peepoodo@forest.com">
            </div>
        </div>
        <input type="submit" class="button is-link" value="Envoyer">
    </form>
<?php else: ?>
    <div>
        Vous avez reçu des instructions dans votre boite mail
    </div>
<?php endif; ?>

<script>

</script>

<!-- Call Ajax pour check si user existe en DB ? -->