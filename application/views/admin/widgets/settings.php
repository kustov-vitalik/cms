<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function renderInput(Model_Config_Item $item)
{
    $element = "";

    $element .= Form::label($item->getName(), $item->getTitle(), array());

    switch ($item->getType())
    {
        case 'string':
            $element .= Form::input($item->getName(), $item->getValue());
            break;
        case 'number':
            $element .= "<input type='number' name='{$item->getName()}' value='{$item->getValue()}'>";
            break;
        case 'text' :
        case 'richtext' :
            $element .= "<textarea name='{$item->getName()}' cols='80' rows='5'>{$item->getValue()}</textarea>";
            break;
        default:
            $element .= Form::input($item->getName(), $item->getValue());
            break;
    }

    return $element;
}

/* @var $widget Model_Widget */
?>
<form method="post" action="/admin/widgets/settings/<?= $widget->pk() ?>">

    <fieldset>
        <legend><?= $widget->getSelfConfig()->getTitle() ?></legend>
        <p><?= $widget->getSelfConfig()->getDescription() ?></p>

        <?= Form::checkbox('enable', 'on', $widget->getSelfConfig()->isEnable()); ?>
        <label for="enable">Настройки включены</label>

        <? $it = $widget->getSelfConfig()->getItems()->getIterator(); ?>
        <? $it->rewind() ?>
        <? while ($it->valid()): ?>
            <? $item = $it->current(); /* @var $item Config_Item_Interface */ ?>
            <fieldset>
                <legend><?= $item->getTitle(); ?></legend>
                <p><?= $item->getDescription() ?></p>
                <?= renderInput($item); ?>


                <? if (!$item->getAvailableValues()->isEmpty()): ?>
                    <fieldset>
                        <legend>Список допустимых значений параметра "<?= $item->getTitle() ?>"</legend>
                        <ul class="checks">
                            <? $avIt = $item->getAvailableValues()->getIterator(); ?>
                            <? $avIt->rewind(); ?>
                            <? while ($avIt->valid()): ?>
                            <li><?= $avIt->current()->getValue(); ?></li>

                            <? $avIt->next(); ?>
                            <? endwhile; ?>
                        </ul>
                    </fieldset>
                <? endif; ?>

            </fieldset>

            <? $it->next(); ?>
        <? endwhile; ?>



    </fieldset>

    <input type="submit" value="Сохранить" />

</form>