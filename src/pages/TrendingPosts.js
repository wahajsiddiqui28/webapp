import React, { useState, useEffect } from 'react';

function TrendingPosts() {
  const [posts, setPosts] = useState([]);

  useEffect(() => {
    // Fetch posts from the backend
    const fetchPosts = async () => {
      try {
        const response = await fetch('http://localhost:9090/web-application/my-web-app/backend/fetch_posts.php');
        const result = await response.json();
        if (result.success) {
          setPosts(result.data); // Store posts in state
        } else {
          console.error('Failed to fetch posts');
        }
      } catch (error) {
        console.error('Error fetching posts:', error);
      }
    };

    fetchPosts();
  }, []); // Empty array means this will run only once when the component mounts

  return (
        <div className="posts-list">
        <h2>Trending Posts</h2>
            {posts.length > 0 ? (
            posts.map((post) => (
                <div className="post-card">
                    <img
                    src={`http://localhost:9090/web-application/my-web-app/backend/${post.file_path}`}
                    alt={post.title}
                    className="img-fluid"
                    />
                    <h3>{post.title}</h3>
                    <p>{post.description}</p>
                    <div className="post-footer">
                    <span>Views: {post.views}</span>
                    <span>Likes: {post.likes}</span>
                    </div>
                </div>
            ))
            ) : (
            <p>No posts available</p>
            )}
        </div>

  );
}

export default TrendingPosts;
