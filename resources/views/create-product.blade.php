<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store Product Form</title>

    
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Select2 Links -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

</head>
<body>

    <div class="main">

        <div class="container">
            <h2>Add new product</h2>
            <form method="POST" id="add-product-form" class="signup-form" enctype="multipart/form-data">
                <h3>
                    Basic Details
                </h3>
                <fieldset>
                    <div class="form-row">
                        <div class="form-file">
                            <input type="file" class="inputfile" name="main_image" id="main_image"  onchange="readURL(this);" />
                            <label for="main_image">
                                <figure>
                                    <img src="{{ asset('images/your-picture.png') }}" alt="" class="product_main_image">
                                </figure>
                                <span class="file-button">choose picture</span>
                            </label>
                        </div>
                        <div class="form-group-flex">
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="Product Name" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="sku" id="sku" placeholder="Product SKU" />
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Attributes
                </h3>
                <fieldset>
                        <div class="form-flex">
                            <select multiple="multiple" id="attributeCategoriesSelect" style="min-width: 100px !important;">
                                @foreach ($attributeCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="categories-container"></div>
                </fieldset>

                <h3>
                    Combinations
                </h3>
                <fieldset>
                    <div id="combinations-container">

                    </div>
                </fieldset>
            </form>
        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-steps/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#attributeCategoriesSelect').select2({
                theme:"classic",
                placeholder: "Select attribute categories"
            });
        });
        const attributes = @json($attributes);
        const attributeCategories = @json($attributeCategories);

        let selectedAttributes = {};
        let previouslySelected = [];
        let lastSelectedCategory = null;
        $("#attributeCategoriesSelect").change(function () {
            let currentlySelected = $(this).val(); // all selected categories
            
            isAdding = currentlySelected.length > previouslySelected.length;

            if(isAdding)
                lastSelectedCategory = currentlySelected.find( (categoryId) => ! previouslySelected.includes(categoryId) );
            else
                lastSelectedCategory = previouslySelected.find( (categoryId) => ! currentlySelected.includes(categoryId) );

            previouslySelected = currentlySelected;

            let choosedCategory = attributeCategories.find( (category) => category.id == lastSelectedCategory );

            if(isAdding)
            {
                categoryAttributes = '';
                $.each(choosedCategory.attributes, function (indexInArray, attribute) { 
                    if(choosedCategory.type == 'text')
                    {
                        categoryAttributes += `
                        <div class="form-flex" style="padding:0;align-items:center">
                            <input class="attribute" data-id="${attribute.id}" data-category-id="${choosedCategory.id}" type="checkbox" id="attribute-${attribute.id}">
                            <label for="attribute-${attribute.id}">${attribute.value}</label>
                        </div>
                        `;
                    }
                    else
                    {
                        categoryAttributes += `
                        <div class="form-flex" style="padding:0;align-items:center">
                            <input class="attribute" data-id="${attribute.id}" data-category-id="${choosedCategory.id}" type="checkbox" id="attribute-${attribute.id}">
                            <div for="attribute-${attribute.id}" style="background-color:${attribute.value};width:40px;height:20px;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"></div>
                        </div>
                        `;
                    }
                });
                $('#categories-container').append(`
                <div class="form-flex" style="margin-top: 20px;padding:0" id="category-${choosedCategory.id}">
                    <h2 style="margin: 0;padding: 0;">${choosedCategory.name}</h2>
                    ${categoryAttributes}
                </div>
                `);
                initAttributes();
            }
            else
            {
                $(`#category-${lastSelectedCategory}`).remove();
                delete selectedAttributes[lastSelectedCategory];
                console.log(selectedAttributes);
            }
            

        });

        let initAttributes = () => {
            $(".attribute").off();
            $(".attribute").change(function(){
                attributeId = $(this).data('id');
                categoryId = $(this).data('category-id');
                
                if(!$(this).hasClass('selected'))
                {
                    $(this).addClass('selected');
                    if(selectedAttributes[categoryId] == undefined)
                    {
                        selectedAttributes[categoryId] = [attributeId];
                    }
                    else
                        selectedAttributes[categoryId].push(attributeId);
                }
                else
                {
                    $(this).removeClass('selected');
                    index = selectedAttributes[categoryId].indexOf(attributeId);
                    if(selectedAttributes[categoryId].join() == attributeId)
                        delete selectedAttributes[categoryId];
                    else
                        selectedAttributes[categoryId].splice(index,1);

                }
            });
        }

    </script>
</body>
</html>