<div class="row">
    <div class="col-md-12">
    <h1>Профиль</h1>

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <?php if ($this->user) { ?>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <td>Id</td>
                        <td>Аватар</td>
                        <td>Имя</td>
                        <td>email</td>
                        <td>активирован ?</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="<?= ($this->user->user_active == 0 ? 'inactive' : 'active'); ?>">
                            <td><?= $this->user->user_id; ?></td>
                            <td class="avatar">
                                <?php if (isset($this->user->user_avatar_link)) { ?>
                                    <img src="<?= $this->user->user_avatar_link; ?>" />
                                <?php } ?>
                            </td>
                            <td><?= $this->user->user_name; ?></td>
                            <td><?= $this->user->user_email; ?></td>
                            <td><?= ($this->user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </div>
</div>
