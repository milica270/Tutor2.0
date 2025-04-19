<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">
    @vite('resources/js/app.js')
    @inertiaHead
    @routes
    <style>
        :root {
        --lightGrey: #9c9c9c;
        --darkGrey: #464D53;
        --lightBlue: rgb(148, 223, 230);
        --blue: rgb(31, 99, 151);
        --darkBlue: rgb(3, 39, 60);
        --gradient: linear-gradient(210.41deg,rgb(3, 39, 60) 1.14%,rgb(110, 191, 198) 100.75%);
        }

        .btn1{
            background: var(--gradient);
            border: none !important;
            padding: 11px !important;
            color: white !important;
            font-weight: bold !important;
        }

        .btn1:hover {
            cursor: pointer;
            border: 1px solid var(--darkBlue) !important;
            padding: 10px !important;
            background: white;
            color: var(--gradient) !important;
        }

        .blur {
            background: var(--lightBlue);
            position: absolute;
            border-radius: 50%;
            filter: blur(150px);
            z-index: -9;
        }

        .link_style {
            color: white;
            text-decoration: none;
        }

        .link_style:hover {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }


        .custom-radio {
    width: 30px;  /* Increase the size of the radio button */
    height: 30px;
    border-radius: 50%;  /* Make the radio button fully rounded */
    border: 5px solid #007bff;  /* Add a border with your preferred color */
    background-color: #fff;  /* Set background color */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Add transition for smooth effect */
}

.custom-radio:hover {
    cursor: pointer;
}

.custom-radio:checked {
    background-color: #007bff;  /* Change background color when checked */
    border-color: #0056b3;  /* Change border color when checked */
    transform: scale(1.2);  /* Make the button slightly bigger when checked */
}

.custom-radio:focus {
    outline: none;  /* Remove the outline when focused */
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);  /* Add glow effect on focus */
}

.form-check-label {
    font-size: 16px;  /* Adjust the font size for better readability */
    padding-left: 0px;  /* Add some space between the radio button and the label */
    display: inline-block;
    cursor: pointer;
}



    </style>
</head>
<body>
    @inertia
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


