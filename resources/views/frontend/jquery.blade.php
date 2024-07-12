<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOM Traversal Practice</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .list-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="list-container">
    <h2>List 1</h2>
    <ul id="list1">
        <li>Item 1.1</li>
        <li>Item 1.2</li>
        <li>Item 1.3
            <ul>
                <li>Item 1.3.1</li>
                <li>Item 1.3.2</li>
            </ul>
        </li>
        <li>Item 1.4</li>
    </ul>
</div>

<div class="list-container">
    <h2>List 2</h2>
    <ol id="list2">
        <li>Item 2.1</li>
        <li>Item 2.2</li>
        <li>Item 2.3
            <ol>
                <li>Item 2.3.1</li>
                <li>Item 2.3.2</li>
            </ol>
        </li>
        <li>Item 2.4</li>
    </ol>
</div>

<div class="list-container">
    <h2>List 3</h2>
    <ul id="list3">
        <li>Item 3.1</li>
        <li>Item 3.2</li>
        <li>Item 3.3</li>
        <li>Item 3.4
            <ul>
                <li>Item 3.4.1</li>
                <li>Item 3.4.2
                    <ul>
                        <li>Item 3.4.2.1</li>
                        <li>Item 3.4.2.2</li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        // Example jQuery traversals:

        // Select all list items
        $('li').css('color', 'blue');

        // Select all direct children of ul elements
        $('ul > li').css('font-weight', 'bold');

        // Select all descendants of the first list
        $('#list1 li').each(function(index, element) {
            console.log($(element).text());
        });

        // Select all parent elements of a specific list item
        $('li:contains("Item 3.4.2.1")').parents().each(function(index, element) {
            console.log($(element).prop('tagName'));
        });

        // Select the next sibling of a specific list item
        $('li:contains("Item 2.2")').next().css('background-color', 'yellow');

        let elements1 = $('#list1').children();
        let ul = $(elements1)
       // let item = ul.find('li:first');
        let xx = ul[2].children
        console.log(xx[0].children[0].innerText);

    });
</script>
</body>
</html>
