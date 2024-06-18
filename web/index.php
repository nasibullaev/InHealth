<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Manager</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <link href="https://unpkg.com/@tailwindcss/custom-forms/dist/custom-forms.min.css" rel="stylesheet">
    <!--Replace with your tailwind.css once created-->
    <style>
        .max-h-64 {
            max-height: 16rem;
        }
        /*Quick overrides of the form input as using the CDN version*/
        .form-input,
        .form-textarea,
        .form-select,
        .form-multiselect {
            background-color: #edf2f7;
        }
    </style>

</head>

<body class="bg-gray-100 text-gray-900 tracking-wider leading-normal">

    <!--Container-->
    <div class="container w-full flex flex-wrap mx-auto px-2 pt-8 lg:pt-16 mt-2">
        <div class="w-full lg:w-1/5 px-6 text-xl text-gray-800 leading-normal">
            <p class="text-base font-bold py-2 lg:pb-6 text-gray-700">Menu</p>
            <div class="block lg:hidden sticky inset-0">
                <button id="menu-toggle" class="flex w-full justify-end px-3 py-3 bg-white lg:bg-transparent border rounded border-gray-600 hover:border-yellow-600 appearance-none focus:outline-none">
                    <svg class="fill-current h-3 float-right" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </button>
            </div>
            <div class="w-full sticky inset-0 hidden max-h-64 lg:h-auto overflow-x-hidden overflow-y-auto lg:overflow-y-hidden lg:block mt-0 my-2 lg:my-0 border border-gray-400 lg:border-transparent bg-white shadow lg:shadow-none lg:bg-transparent z-20" style="top:6em;" id="menu-content">
                <ul class="list-reset py-2 md:py-0">
                 
                    
                </ul>
            </div>
        </div>

        <!--Section container-->
        <section class="w-2/1 lg:w-3/5">


            <!--divider-->
            <hr class="bg-gray-300 my-1">



            <!--Title-->
            <h2 class="font-sans font-bold break-normal text-gray-700 px-2 pb-8 text-xl">Add FOOD</h2>
            <?php include('message.php'); ?>

            <!--Card-->
            <div id='section2' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">

                <form action="code.php" method="POST">

                    

                    <div class="md:flex mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-600 font-bold md:text-left mb-3 md:mb-0 pr-4" for="my-select">
                                Select ILLNESS
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <select name="illness" class="form-select block w-full focus:bg-white" id="my-select">
                                <option value="default">Default</option>
                                <option value="Ischemic heart disease">Ischemic heart disease</option>
                                <option value="Stroke">Stroke</option>
                                <option value="Lower respiratory infections">Lower respiratory infections</option>
                                <option value="Chronic obstructive pulmonary disease">Chronic obstructive pulmonary disease</option>
                                <option value="Trachea, bronchus, and lung cancers">Trachea, bronchus, and lung cancers</option>
                                <option value="Diabetes mellitus">Diabetes mellitus</option>
                                <option value="Alzheimers disease and other dementias">Alzheimer's disease and other dementias</option>
                                <option value="Dehydration due to diarrheal diseases">Dehydration due to diarrheal diseases</option>
                                <option value="Tuberculosis">Tuberculosis</option>
                                <option value="Cirrhosis">Cirrhosis</option>
                            </select>

                            <p class="py-2 text-sm text-gray-600">now there are only 10 illnesses</p>
                        </div>
                    </div>

                    <div class="md:flex mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-600 font-bold md:text-left mb-3 md:mb-0 pr-4" for="my-textfield">
                                Name of the FOOD
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="form-input block w-full focus:bg-white" id="my-textfield" type="text" value="" name="food_name" required>
                            <p class="py-2 text-sm text-gray-600">write down name of the food</p>
                        </div>
                    </div>

                    <div class="md:flex mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-600 font-bold md:text-left mb-3 md:mb-0 pr-4" for="my-textarea">
                                Recipe of the FOOD
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <textarea class="form-textarea block w-full focus:bg-white" id="my-textarea" value="" rows="8" name="recipe" required></textarea>
                            <p class="py-2 text-sm text-gray-600">write down the recipe of the food</p>
                        </div>
                    </div>

                    <div class="md:flex mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-600 font-bold md:text-left mb-3 md:mb-0 pr-4" for="my-textfield" >
                                Image URL
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="form-input block w-full focus:bg-white" id="my-textfield" type="text" value="" name="img_url" required>
                            <p class="py-2 text-sm text-gray-600">write down link of the image</p>
                        </div>
                    </div>

                    <div class="md:flex mb-6">
                        <div class="md:w-1/3">
                            <label class="block text-gray-600 font-bold md:text-left mb-3 md:mb-0 pr-4" for="my-textfield">
                                Ingredients of the FOOD
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="form-input block w-full focus:bg-white" id="my-textfield" type="text" value="" name="ingredients" required>
                            <p class="py-2 text-sm text-gray-600">write down the ingredients. don't forget to use comma "," between ingredients</p>
                        </div>
                    </div>

                    <div class="md:flex md:items-center">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/3">
                            <button type="submit" class="shadow bg-yellow-700 hover:bg-yellow-500 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="button" name="add_food">
                                Save
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!--/Card-->

            <!--divider-->
            <hr class="bg-gray-300 my-12">

            

        </section>
        <!--/Section container-->



      </div>
      <!--/container-->