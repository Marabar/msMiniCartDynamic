<li>
    <div class="clearfix">
        <div class="media col-xs-10">
            <a class="pull-left" href="[[~[[+id_d]]]]">
                <img class="media-object" src="[[+img_d]]" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">[[+name_d]]</h4>
                <div>
                        <span>[[+count_d]]</span> x <span>[[+price_d]]</span> = <span>[[+sum_d]]</span>
                </div>
            </div>
        </div>
        <form method="post" class="ms2_form col-xs-2">
            <input type="hidden" name="key" value="[[+key_d]]">
            <input type="hidden" name="id" value="[[+id_d]]">
            <button class="btn btn-default" type="submit" name="ms2_action" value="cart/remove" title="Удалить">X</button>
        </form>
    </div>
</li>