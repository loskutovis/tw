<div class="index-container text-center">
    <form id="main-form">
        <div class="alert-container alert"></div>
        <div class="form-group col-md-2 col-sm-6">
            <label>
                Укажите адрес сайта<br/>
                <input type="text" class="form-control" name="url" id="url" />
            </label>
            <br/>

            <label>
                Выберите тип поиска<br/>
                <select class="form-control" name="search_type" id="search-type">
                    <option value="link">Ссылка</option>
                    <option value="image">Изображение</option>
                    <option value="text">Текст</option>
                </select>
            </label>
            <br/>

            <label id="search-label">
                Введите текст для поиска<br/>
                <input type="text" class="form-control" name="search_text" id="search-text" />
            </label>
            <br/>

            <button type="button" id="form-submit" class="btn btn-success">Отправить</button>
        </div>
    </form>
</div>