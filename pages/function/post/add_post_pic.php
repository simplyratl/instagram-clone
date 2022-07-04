<?php

$target = "../../../uploads/posts/" . basename($_FILES['formData']['name']);

move_uploaded_file($_FILES['formData']['tmp_name'], $target);
