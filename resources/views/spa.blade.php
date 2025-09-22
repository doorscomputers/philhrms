<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PH HRMS - Human Resource Management System">
    <meta name="keywords" content="hrms, hr, human resource, employee management">
    <meta name="author" content="PH HRMS">
    <title>PH HRMS - Employee Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/inertia-app.js'])
    @inertiaHead
</head>

<body class="bg-gray-50">
    @inertia
</body>

</html>