import React from 'react';

function Home() {
    return (
        <div className="container mt-5">
            <h1>Welcome to My App</h1>
            <div className="row">
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-body">
                            <h5 className="card-title">Trending Post 1</h5>
                            <p className="card-text">This is a brief description of a trending post.</p>
                        </div>
                    </div>
                </div>
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-body">
                            <h5 className="card-title">Trending Post 2</h5>
                            <p className="card-text">This is a brief description of a trending post.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Home;
