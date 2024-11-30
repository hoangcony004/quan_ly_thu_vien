@if($errors->any())
<div
    style="color: red; margin: 10px 0; padding: 10px; border: 1px solid red; border-radius: 5px; background-color: #ffe6e6;">
    <ul style="margin: 0; padding: 0; list-style: none;">
        @foreach ($errors->all() as $error)
        <li style="margin-bottom: 5px;">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif