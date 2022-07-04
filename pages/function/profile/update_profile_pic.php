<?php

$target = "../../../uploads/avatars/" . basename($_FILES['formData']['name']);

move_uploaded_file($_FILES['formData']['tmp_name'], $target);
