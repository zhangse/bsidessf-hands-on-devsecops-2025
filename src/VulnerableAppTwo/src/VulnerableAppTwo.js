const express = require('express');
const mongoose = require('mongoose');
const marked = require('marked');
const _ = require('lodash');
const bodyParser = require('body-parser');

const app = express();
const port = 3000;

// Middleware
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Vulnerable MongoDB connection setup
mongoose.connect('mongodb://localhost:27017/vulnerableApp', { useNewUrlParser: true, useUnifiedTopology: true });
const UserSchema = new mongoose.Schema({
  username: String,
  password: String
});
const User = mongoose.model('User', UserSchema);

// Route: Unsafe Deserialization (using lodash)
app.post('/api/submit', (req, res) => {
  const userData = _.cloneDeep(req.body);
  console.log(userData);
  res.send('Data received');
});

// Route: SQL (NoSQL) Injection
app.post('/api/login', async (req, res) => {
  const { username, password } = req.body;
  
  // Validate input
  if (typeof username !== 'string' || typeof password !== 'string') {
    return res.status(400).send('Invalid input');
  }
  
  // Safe query using $eq operator
  const user = await User.findOne({ username: { $eq: username }, password: { $eq: password } });
  if (user) {
    res.send('Login successful');
  } else {
    res.send('Login failed');
  }
});

// Route: Stored XSS
app.post('/api/comment', (req, res) => {
  const { comment } = req.body;
  // Vulnerable to XSS, as marked doesn't sanitize input by default
  const htmlComment = marked(comment);
  res.send(htmlComment);
});

app.listen(port, () => {
  console.log(`Vulnerable app listening at http://localhost:${port}`);
});

