<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="icon" type="image/x-icon" href="./img/fljn.jpeg">
    <link rel="stylesheet" href="./css/book.css">
</head>

<body class="appointment-whole">
    <div class="appointment-container">
        <h2>Book Appointment</h2>
        <form action="#">
            <div class="form-group">
                <label for="fullname">Fullname</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your fullname" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="specialty">Select Doctor Specialty</label>
                <select id="specialty" name="specialty" required>
                    <option value="">Choose a Specialty</option>
                    <option value="atiku_bello">Dr. Atiku Bello | General Doctor</option>
                    <option value="samuel_ibrahim">Dr. Samuel Ibrahim | Cardiologist</option>
                    <option value="mary_okoro">Dr. Mary Okoro | Neurologist</option>
                    <option value="john_adewale">Dr. John Adewale | Orthopedist</option>
                    <option value="grace_oladipo">Dr. Grace Oladipo | Ophthalmologist</option>
                    <option value="azeez_balogun">Dr. Azeez Balogun | Dermatologist</option>
                    <option value="ruver_olaoye">Dr. Ruver Olaoye | Pediatrician</option>
                    <option value="esther_adekunle">Dr. Esther Adekunle | Radiologist</option>
                    <option value="habeeb_aliyu">Dr. Habeeb Aliyu | Pathologist</option>
                    <option value="ayeesha_kareem">Dr. Ayeesha Kareem | Urologist</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Preferred Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Preferred Time</label>
                <input type="time" id="time" name="time" required>
            </div>
            <button type="submit" class="book-btn">Book Appointment</button>
        </form>
    </div>
</body>

</html>