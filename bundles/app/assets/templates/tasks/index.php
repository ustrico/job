<?php $this->layout('app:layout');?>

<div class="uk-grid" id="grid">

<main class="uk-width-2-3">
    <?if (!empty($admin)) include $this->resolve('app:tasks/form'); ?>

    <?php include $this->resolve('app:tasks/filter'); ?>

    <div id="tasksi"></div>

</main>

<aside class="uk-width-1-3"  data-uk-grid-match="{target:'main'}">
    <?php include $this->resolve('app:price/price'); ?>
</aside>

</div>

<?php include $this->resolve('app:tasks/_modaltask'); ?>