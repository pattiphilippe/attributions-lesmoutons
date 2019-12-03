<!doctype html>
<html lang="en">
  <head>
    <title>PDF</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <style>
      html {
    font-family: sans-serif;
}

body>header {
    background-color: #236ab9;
    height: 60px;
    padding-top: 1rem;
    padding-bottom: 1rem;
    min-height: 5rem;
}
body>header h1 {
    color: white;
    font-family: sans-serif;
    font-size: 2rem;
}

#logo{
    float: left;
    margin: 0px 20px;
    height: 60px;
}

h2 {
    color: #236ab9;
    font-family: sans-serif;
    font-size: 2rem;
}

main h1 {
    font-size: 1.4rem;
    display: inline-block;
    background-color: #236ab9;
    color: white;
    margin: 10px 0px;
    padding: .1em 1em;
    border: 2px solid #2E4A62;
    border-radius: 40px 10px;
}

ul li a {
    display: block;
}

table {
    border: 1px;
    border-style: groove;
    border-color: black;
}

table tr:nth-child(even) {
    background-color: #eaf2fb;
}

table th {
    background-color: #236ab9;
    color: white;
    padding: 2px 10px;
}

table td {
    padding: 2px 10px;
}

body>footer {
    background-color: #eaf2fb;
    margin: 1rem 0px;
    padding: .2rem 0px;
}

div {
    margin-bottom: 15px;
}
       </style>
  </head>
  <body>
    @yield('content')
  </body>
</html>