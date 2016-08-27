<?php if(isset($node['root'])): ?>
            <li class="IsRoot ExpandOpen">
<?php elseif(isset($node['child'])): ?>
        <li class="Node ExpandOpen">
<?php else: ?>            
        <li class="Node ExpandLeaf">
<?php endif; ?>
            <div class="Expand"></div>
            <div class="Content" data-id="<?= $node['id'] ?>"><?= $node['name'] ?></div>
<?php if(isset($node['child'])): ?>
            <ul class="child">
                <?= $this->getHTML($node['child']) ?>
            </ul>
<?php endif; ?>
        </li>

