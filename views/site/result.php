<?php
/**
 * @var $result mixed список результатов
 */
?>
<div class="index-container text-center">
    <a href="/">На главную</a>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Сайт</th>
                <th>Количество элементов</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result as $match) {
            ?>
                    <tr>
                        <td>
                            <span class="show-values">
                                <?= $match['url'] ?>
                            </span>
                            <div class="values-container">
                                <pre><?= $match['found']?></pre>
                            </div>
                        </td>
                        <td>
                            <?= $match['count'] ?>
                        </td>
                    </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <div class="highslide"></div>
</div>
