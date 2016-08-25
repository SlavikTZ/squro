<li><?php if(isset($node['child'])): ?>
    <span class="glyphicon glyphicon-play"></span>
<?php endif; ?><a href="" ><?= $node['name'] ?></a>
    <?php if(isset($node['child'])): ?>
        <ul>
            <?= $this->getHTML($node['child']) ?>
        </ul>
    <?php endif; ?>
</li>

