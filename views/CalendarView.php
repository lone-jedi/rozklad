<h5 data-group-id=" <?= $idGroup['id_groups'] ?? ''?>">Група: <?= $idGroup['name_groups'] ?? ''?><?=$idGroup['subgroup'] ?? '' ?></h5>

<div class="grid">

    <div class="row">
        <div class="cell">   
            <ul class="h-menu horizontal open bg-cyan fg-white"
            >
                <?php foreach($month as $num => $monthInfo):?>
                    <?php foreach($monthInfo['name'] as $latName => $ukrName):?>
                        <?php if($activeMonth == $num):?>
                            <li class="bg-green">
                        <?php else:?>
                            <li>
                        <?php endif;?>
                        <a href="<?= SCHEDULE_HOST . "?id={$idGroup['id_groups']}&month=$num&year={$monthInfo['year']}"?>"><?= $ukrName ?></a></li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                
            </ul>                
        </div>
    </div>

    <div class="row">
        <div class="cell">   
            <div class="pos-relative">
                <a class="button" href="<?= SCHEDULE_HOST ?>?id=<?= $idGroup['id_groups'] ?>&month=<?= date('m') ?>&year=<?= date('Y') ?>#currentDay">Сегодня</a>
            </div>
        </div>
    </div>

    <div class="row no-gap no-visible visible-lg">
        <div class="cell"><div class="text-center">ПН</div></div>
        <div class="cell"><div class="text-center">ВТ</div></div>
        <div class="cell"><div class="text-center">СР</div></div>
        <div class="cell"><div class="text-center">ЧТ</div></div>
        <div class="cell"><div class="text-center">ПТ</div></div>
        <div class="cell"><div class="text-center">СБ</div></div>
    </div>

    
    <div class="row">                
        <?php 
            foreach($lessons as $day => $lesson):
        ?>
        <div class="cell-sm-full cell-md-3 cell-lg-2 main-calendar">
            <?php if($lesson['isCurrent'] != 0):?>   
                <div class="bg-cyan text-center fg-white mb-0 d-none-fs d-none-sm d-none-md d-block-lg"><?= explode('-', $day)[2] ?></div>
                <div class="row bg-cyan fg-white mb-0 ml-0 mr-0 d-none-lg">
                    <div class="cell-fs-2 text-center"><?= $lesson['day'] ?></div>
                    <div class="cell-fs-10 text-center"><?= explode('-', $day)[2] ?></div>
                </div>
            <?php else: ?>
                <a name="currentDay"></a>
                <div class="bg-green text-center fg-white mb-0 d-none-fs d-none-sm d-none-md d-block-lg"><?= explode('-', $day)[2] ?></div>
                <div class="row bg-green fg-white mb-0 ml-0 mr-0 d-none-lg">
                    <div class="cell-fs-2 text-center"><?= $lesson['day'] ?></div>
                    <div class="cell-fs-10 text-center"><?= explode('-', $day)[2] ?></div>
                </div>
            <?php endif;?>
            
            <table class="table subcompact row-hover row-border cell-border mt-0 mr-0 ml-0" data-role="table" 
                    data-show-search="false"
                    data-show-rows-steps="false"
                    data-show-table-info="false"
                    data-show-pagination="false"
                    data-show-activity="false"
                    data-horizontal-scroll="true"
                    data-role="table">
                <thead class="bg-cyan fg-white text-center">
                    <tr>
                        <th data-name="couple"></th>
                        <th data-name="name"></th>
                    </tr>
                </thead>
                <tbody class="cell-hover">
                    <?php foreach($lesson['classes'] as $numOfСouple => $content):?>
                    <?php 
                        if($numOfСouple == 7 && (isset($lesson['classes'][7]['id_item']) || isset($lesson['classes'][8]['id_item']) || isset($lesson['classes'][9]['id_item']))) {
                            break;
                        }
                    ?>
                    <tr>
                        <td><?= $numOfСouple ?></td>
                        <td >
                            <div class="lesson-info">
                                <input type="hidden" name="lesson-id" value="<?= $content['id_item'] ?>">
                                <input type="hidden" name="lesson-week" value="<?= $content['week'] ?>">
                                <div class="lesson-name"><?= $content['short_subject'] ?? ''?></div>    
                                <div class="lesson-type"><?= $content['type'] ?? '<div></div>' ?></div>
                                <div class="lesson-address"><?= $content['address'] ?? ''?></div>                       
                                <div class="lesson-teacher"><?= $content['short_teacher'] ?? ''?></div>
                                
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="info-box zoom-info-box" data-role="infobox" >
    <!-- Динамически создается содержимое infobox с zoom или другими данными -->
</div>