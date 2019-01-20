<div class="wrap">
        <h1>{{ $page->pageTitle() }}</h1>
        <form action="options.php" method="post" enctype="multipart/form-data">
            @php

            // output security fields for the registered setting "{{ $this->optionGroup }}"
                 settings_fields($page->optionGroup());
             /*
                 =======================fields=================
                text
                hidden
                url
                number
                email
                color
                search
                date
                time
                range
                checkbox
                checkboxes
                radios
                password
                textarea
                select
             */
            @endphp


                <small>the path of this view is (wp-content\themes\laraveltheme\resources\views\admin\options.blade.php add your own inputs as you want or redesign the view)</small>
                <p>{!! $form->email('email', ['attributes' => ['placeholder' => 'foo@example.com']]) !!}</p>
                <p>{!! $form->text('name', ['attributes' => ['class' => 'text','placeholder' => 'your name']]) !!}</p>
                <p>{!! $form->textarea('about-us') !!}</p>
            @php
                submit_button();
            @endphp
        </form>
</div>