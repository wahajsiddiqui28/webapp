import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Header from './components/Header';
import Home from './pages/Home';
import Signup from './pages/Signup';
import Login from './pages/Login';
import 'bootstrap/dist/css/bootstrap.min.css';
import TrendingPosts from './pages/TrendingPosts';
import UploadNewPost from './pages/UploadNewPost';

function App() {
    return (
        <Router>
            <Header />
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/signup" element={<Signup />} />
                <Route path="/login" element={<Login />} />
                <Route path="/uploadpost" element={<UploadNewPost />} />
                <Route path="/trendingpost" element={<TrendingPosts />} />
            </Routes>
        </Router>
    );
}

export default App;
