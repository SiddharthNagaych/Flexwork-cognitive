const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');

const app = express();
const port = 3000;

// Middleware to parse JSON and urlencoded form data
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Serve static files from the 'public' directory
app.use(express.static(path.join(__dirname, 'public')));

// Connect to MongoDB
mongoose.connect('mongodb://localhost/FlexWork', {
    useNewUrlParser: true,
    useUnifiedTopology: true
})
.then(() => console.log('Connected to MongoDB'))
.catch(err => console.error('Could not connect to MongoDB...', err));

// Define schemas for job and internship form data
const jobSchema = new mongoose.Schema({
    email: String,
    name: String,
    phone: String,
    college: String,
    branch: String,
    gender: String,
    position: String
});

const internshipSchema = new mongoose.Schema({
    email: String,
    name: String,
    phone: String,
    college: String,
    branch: String,
    gender: String,
    position: String
});

const getInTouchSchema = new mongoose.Schema({
    name: String,
    lastname: String,
    email: String,
    message: String
});

// Create models for job and internship form data
const JobForm = mongoose.model('JobForm', jobSchema);
const InternshipForm = mongoose.model('InternshipForm', internshipSchema);
const GetInTouch = mongoose.model('GetInTouch', getInTouchSchema);

// Serve HTML pages from the 'views' directory
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'index.html'));
});
app.get('/index.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'index.html'));
});


app.get('/about.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'about.html'));
});

app.get('/Contacts.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'Contacts.html'));
});

app.get('/products.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'products.html'));
});

app.get('/jobsform.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'jobsform.html'));
});

app.get('/form.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'form.html'));
});

app.get('/intern.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'intern.html'));
});
app.get('/verification.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'verification.html'));
});

app.get('/services.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'services.html'));
});
app.get('/jobs.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'views', 'jobs.html'));
});

// Handle job form submission
app.post('/submit-job', (req, res) => {
    const { email, name, phone, college, branch, gender, position } = req.body;

    // Create a new job form data instance
    const jobFormData = new JobForm({
        email,
        name,
        phone,
        college,
        branch,
        gender,
        position
    });

    // Save the job form data to the database
    jobFormData.save()
        .then(() => res.send('Job form submitted successfully.'))
        .catch(err => res.status(400).send('Error saving job form data: ' + err.message));
});

// Handle internship form submission
app.post('/submit-internship', (req, res) => {
    const { name,gender,email, phone, college, branch,position } = req.body;

    // Create a new internship form data instance
    const internshipFormData = new InternshipForm({
        name,
        gender,
        email,
        phone,
        college,
        branch,
        position
    });

    // Save the internship form data to the database
    internshipFormData.save()
        .then(() => res.send('Internship form submitted successfully.'))
        .catch(err => res.status(400).send('Error saving internship form data: ' + err.message));
});

// Handle get-in-touch form submission
app.post('/submit-get', (req, res) => {
    const { name, lastname, email, message } = req.body;

    // Create a new get-in-touch form data instance
    const getInTouchFormData = new GetInTouch({
        name,
        lastname,
        email,
        message
    });

    // Save the get-in-touch form data to the database
    getInTouchFormData.save()
        .then(() => res.send('Get-in-touch form submitted successfully.'))
        .catch(err => res.status(400).send('Error saving get-in-touch form data: ' + err.message));
});

// Start the server
const server = app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});

// Handle server shutdown gracefully
process.on('SIGINT', () => {
    console.log('Shutting down gracefully...');

    mongoose.connection.close(() => {
        console.log('MongoDB connection closed.');
        server.close(() => {
            console.log('Server closed.');
            process.exit(0); // Exit the Node.js process
        });
    });
});
