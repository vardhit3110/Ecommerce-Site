<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Master</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .custom-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
        }
    </style>
</head>

<body>

    <div class="container custom-container shadow p-3 mb-5 bg-body-tertiary rounded">
        <h3 class="text-center mb-4">Create New Event</h3>

        <form action="partials/event_handle.php" method="post" id="myForm">
            <div class="mb-3">
                <label for="eventname" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="eventname" name="eventname" placeholder="Enter event name"
                    required>
            </div>

            <div class="mb-3">
                <label for="eventdesc" class="form-label">Description</label>
                <textarea class="form-control" id="eventdesc" name="eventdesc" rows="3"
                    placeholder="Enter event description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="eventdate" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="eventdate" name="eventdate" required min="">
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="index.php" class="btn btn-secondary">Close</a>
                <button type="submit" name="add_event" class="btn btn-primary">Create Event</button>
            </div>
        </form>

        <script>
            $(document).ready(function () {

                let today = new Date().toISOString().split('T')[0];
                $('#eventdate').attr('min', today);

                $('#myForm').validate({
                    rules: {
                        eventname: {
                            required: true,
                            minlength: 3
                        },
                        eventdesc: {
                            required: true,
                            minlength: 5
                        },
                        eventdate: {
                            required: true,
                            date: true
                        }
                    },
                    messages: {
                        eventname: {
                            required: "Please enter the event name.",
                            minlength: "Event name must be at least 3 characters long."
                        },
                        eventdesc: {
                            required: "Please enter a description.",
                            minlength: "Description should be at least 5 characters."
                        },
                        eventdate: {
                            required: "Please select a date.",
                            date: "Please enter a valid date."
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });

        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>