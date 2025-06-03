const functions = require("firebase-functions");
const admin = require("firebase-admin");
const express = require("express");
const cors = require("cors");

// Initialize Firebase Admin
admin.initializeApp();
const db = admin.firestore();

const app = express();

// Configure CORS for GitHub Pages
const corsOptions = {
  origin: [
    "http://localhost:3000",
    "http://localhost:5173",
    "https://yipa-01.github.io", // Your GitHub Pages URL
    "https://reda-yahyani-portfolio.web.app",
    "https://reda-yahyani-portfolio.firebaseapp.com",
  ],
  credentials: true,
  methods: ["GET", "POST", "PUT", "DELETE", "OPTIONS"],
  allowedHeaders: ["Content-Type", "Authorization"],
};

app.use(cors(corsOptions));
app.use(express.json());

// Routes
// Get all projects
app.get("/projects", async (req, res) => {
  try {
    const snapshot = await db.collection("projects")
        .where("visibility", "==", "public")
        .orderBy("created_at", "desc")
        .get();

    const projects = [];
    snapshot.forEach((doc) => {
      projects.push({id: doc.id, ...doc.data()});
    });

    res.json(projects);
  } catch (error) {
    console.error("Error fetching projects:", error);
    res.status(500).json({error: "Failed to fetch projects"});
  }
});

// Get featured projects
app.get("/projects/featured", async (req, res) => {
  try {
    const snapshot = await db.collection("projects")
        .where("visibility", "==", "public")
        .where("featured", "==", true)
        .orderBy("created_at", "desc")
        .get();

    const projects = [];
    snapshot.forEach((doc) => {
      projects.push({id: doc.id, ...doc.data()});
    });

    res.json(projects);
  } catch (error) {
    console.error("Error fetching featured projects:", error);
    res.status(500).json({error: "Failed to fetch featured projects"});
  }
});

// Get all skills
app.get("/skills", async (req, res) => {
  try {
    const snapshot = await db.collection("skills")
        .where("visibility", "==", "public")
        .orderBy("category")
        .get();

    const skills = [];
    snapshot.forEach((doc) => {
      skills.push({id: doc.id, ...doc.data()});
    });

    res.json(skills);
  } catch (error) {
    console.error("Error fetching skills:", error);
    res.status(500).json({error: "Failed to fetch skills"});
  }
});

// Get education
app.get("/education", async (req, res) => {
  try {
    const snapshot = await db.collection("education")
        .where("visibility", "==", "public")
        .orderBy("start_date", "desc")
        .get();

    const education = [];
    snapshot.forEach((doc) => {
      education.push({id: doc.id, ...doc.data()});
    });

    res.json(education);
  } catch (error) {
    console.error("Error fetching education:", error);
    res.status(500).json({error: "Failed to fetch education"});
  }
});

// Get experience
app.get("/experience", async (req, res) => {
  try {
    const snapshot = await db.collection("experience")
        .where("visibility", "==", "public")
        .orderBy("start_date", "desc")
        .get();

    const experience = [];
    snapshot.forEach((doc) => {
      experience.push({id: doc.id, ...doc.data()});
    });

    res.json(experience);
  } catch (error) {
    console.error("Error fetching experience:", error);
    res.status(500).json({error: "Failed to fetch experience"});
  }
});

// Submit contact message
app.post("/contact", async (req, res) => {
  try {
    const {name, email, subject, message} = req.body;

    // Validate required fields
    if (!name || !email || !message) {
      return res.status(400).json({
        error: "Name, email, and message are required",
      });
    }

    // Save message to Firestore
    const docRef = await db.collection("messages").add({
      name,
      email,
      subject: subject || "Contact Form Submission",
      message,
      created_at: admin.firestore.FieldValue.serverTimestamp(),
      status: "unread",
    });

    res.status(201).json({
      success: true,
      message: "Message sent successfully",
      id: docRef.id,
    });
  } catch (error) {
    console.error("Error saving message:", error);
    res.status(500).json({error: "Failed to send message"});
  }
});

// Get user profile (public info only)
app.get("/profile", async (req, res) => {
  try {
    const snapshot = await db.collection("users")
        .where("role", "==", "admin")
        .limit(1)
        .get();

    if (snapshot.empty) {
      return res.status(404).json({error: "Profile not found"});
    }

    const userData = snapshot.docs[0].data();
    // Only return public profile information
    const publicProfile = {
      name: userData.name,
      email: userData.email,
      bio: userData.bio,
      avatar: userData.avatar,
      location: userData.location,
      social_links: userData.social_links,
      skills_summary: userData.skills_summary,
      experience_years: userData.experience_years,
    };

    res.json(publicProfile);
  } catch (error) {
    console.error("Error fetching profile:", error);
    res.status(500).json({error: "Failed to fetch profile"});
  }
});

// Health check endpoint
app.get("/health", (req, res) => {
  res.json({
    status: "ok",
    timestamp: new Date().toISOString(),
    service: "reda-portfolio-backend",
  });
});

// Export the API
exports.api = functions.https.onRequest(app);
