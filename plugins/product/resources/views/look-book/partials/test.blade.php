<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-24
 * Time: 07:27
 */
?>
<h1>Hello</h1>
@foreach($spaces as $space)
    <h6>{{ $space->text }}</h6>
@endforeach