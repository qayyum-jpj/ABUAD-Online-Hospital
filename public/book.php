<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="icon" type="image/x-icon" href="./img/Ef3iqnGXgAIKpag-removebg-preview.png">
    <link rel="stylesheet" href="./css/book.css">
</head>

<body class="appointment-whole">
    <div class="appointment-container">
        <h2>Book Apppointment</h2>
        <form action="#">
            <div class="form-group">
                <label for="fullname">Fullname</label>
                <input type="text" id="fullname" placeholder="Enter your fullname" required>

            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" placeholder="Enter-your Email" required>
            </div>
            <div class="form-group">
                <label for="Specialty"> Select Doctor Specialty</label>
                <select id="Specialty" required>
                    <option value="">Choose a Speciality</option>
                    <option value=""> Dr.Atiku Bello | General doctor</option>
                    <option value="">Dr.Samuel Ibrahim | Cardiologist</option>
                    <option value="">Dr.Mary Okoro | Neurologist</option>
                    <option value="">Dr.John Adewale | Orthopedist</option>
                    <option value="">Dr.Grace Oladipo | Ophthalmologist</option>
                    <option value="">Dr.Azeez Balogun | Dermatologist</option>
                    <option value="">Dr.Ruver Olaoye | Pediatrician</option>
                    <option value="">Dr. Esther Adekunle | Radiologist</option>
                    <option value="">Dr.Habeeb Aliyu | Pathologist </option>
                    <option value="">Dr.Ayeesha Kareem | Urologist </option>
                </select>
            </div>
            <div class="form-group">
                <label for="Date">Preferred Date</label>
                <input type="date" id="date" required>
            </div>
            <div class="form-group">
                <label for="time">Preferred Time</label>
                <input type="time" id="time" required>
            </div>
            <button type="Submit" class="book-btn">Book Appointment</button>
        </form>
    </div>
</body>

</html>