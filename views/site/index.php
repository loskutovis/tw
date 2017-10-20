<div class="index-container text-center">
    <form id="main-form">
        <div class="alert-container alert"></div>
        <div class="form-group col-md-2 col-sm-6">
            <label>
                Укажите адрес сайта<br/>
                <input type="url" class="form-control" name="url" id="url" />
            </label>
            <br/>

            <label>
                Выберите тип поиска<br/>
                <select class="form-control" name="search_type" id="search_type">
                    <option value="link">Ссылка</option>
                    <option value="image">Изображение</option>
                    <option value="text">Текст</option>
                </select>
            </label>
            <br/>

            <button type="button" id="form-submit" class="btn btn-success">Отправить</button>
        </div>
    </form>
</div>