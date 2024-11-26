import React, { useState } from 'react';

function UploadNewPost() {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    file: null,
  });

  const [error, setError] = useState('');

  const handleChange = (e) => {
    const { name, value } = e.target;
    if (name === 'file') {
      const file = e.target.files[0];

      // File type and size validation
      const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/avi'];
      const maxSize = 5 * 1024 * 1024 * 1024; // 5GB in bytes

      if (file) {
        // Check if file type is valid
        if (!allowedTypes.includes(file.type)) {
          setError('Invalid file type. Only JPEG, PNG, GIF, MP4, and AVI are allowed.');
        }
        // Check if file size is within the limit
        else if (file.size > maxSize) {
          setError('File size is too large. Maximum size allowed is 5GB.');
        } else {
          setFormData((prevData) => ({
            ...prevData,
            [name]: file,
          }));
          setError(''); // Clear error if valid
        }
      }
    } else {
      setFormData((prevData) => ({
        ...prevData,
        [name]: value,
      }));
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    // File must be selected for upload
    if (!formData.file) {
      setError('Please select a file to upload');
      return;
    }

    // Create a new FormData object
    const data = new FormData();
    data.append('title', formData.title);
    data.append('description', formData.description);
    data.append('file', formData.file);

    try {
      const response = await fetch('http://localhost:9090/web-application/my-web-app/backend/upload_post.php', {
        method: 'POST',
        body: data, // FormData object is used for file uploads
      });

      const result = await response.json();
      if (result.success) {
        console.log('Post uploaded successfully');
        setFormData({
          title: '',
          description: '',
          file: null,
        });
        setError('');
      } else {
        setError(result.message || 'Failed to upload post');
      }
    } catch (error) {
      console.error('Error during upload:', error);
      setError('Error during upload');
    }
  };

  return (
    <div className="container mt-5">
      <h2 className="text-center mb-4">Upload Post</h2>
      <form onSubmit={handleSubmit} className="p-4 border rounded shadow-lg bg-light">
        <div className="mb-3">
          <label htmlFor="title" className="form-label">Title</label>
          <input
            type="text"
            className="form-control"
            id="title"
            name="title"
            value={formData.title}
            onChange={handleChange}
            required
            placeholder="Enter post title"
          />
        </div>
        
        <div className="mb-3">
          <label htmlFor="description" className="form-label">Description</label>
          <textarea
            className="form-control"
            id="description"
            name="description"
            value={formData.description}
            onChange={handleChange}
            required
            rows="4"
            placeholder="Enter post description"
          />
        </div>

        <div className="mb-3">
          <label htmlFor="file" className="form-label">Upload File (Image/Video)</label>
          <input
            type="file"
            className="form-control"
            id="file"
            name="file"
            onChange={handleChange}
            required
          />
          {error && <p className="text-danger">{error}</p>}
        </div>

        <div className="text-center">
          <button type="submit" className="btn btn-primary w-100 mt-3">Upload Post</button>
        </div>
      </form>
    </div>
  );
}

export default UploadNewPost;
