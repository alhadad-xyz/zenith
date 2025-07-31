<style>
    .navbar {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(30px);
        -webkit-backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0 0 24px 24px;
        padding: 1.5rem 2rem;
        box-shadow: 0 8px 40px rgba(45, 62, 46, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        margin: 0 1rem;
    }

    .navbar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        border-radius: 0 0 24px 24px;
        opacity: 0.6;
    }

    .brand {
        font-size: 2rem;
        font-weight: 800;
        color: #2d3e2e;
        letter-spacing: -0.02em;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
    }

    .brand-logo {
        height: 30px;
        width: auto;
        display: block;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .nav-link {
        color: #6b7c6d;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 50px;
    }

    .nav-link:hover {
        color: #2d3e2e;
        background: rgba(255, 255, 255, 0.3);
    }

    .nav-link.active {
        color: #ff6b6b;
        background: rgba(255, 107, 107, 0.1);
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .user-name {
        font-weight: 600;
        color: #2d3e2e;
        font-size: 0.95rem;
    }

    .logout-btn {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
        color: white;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        box-shadow: 0 8px 32px rgba(255, 107, 107, 0.3);
        letter-spacing: -0.01em;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 48px rgba(255, 107, 107, 0.4);
        background: linear-gradient(135deg, #ff5252 0%, #ff4444 100%);
    }

    /* Responsive Design */
    @media (max-width: 968px) {
        .navbar {
            padding: 1rem;
            margin: 0;
            border-radius: 0;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .brand {
            font-size: 1.5rem;
        }
        
        .nav-links {
            order: 3;
            width: 100%;
            justify-content: center;
            gap: 1rem;
        }
        
        .user-menu {
            gap: 1rem;
        }
        
        .user-name {
            font-size: 0.85rem;
        }
        
        .logout-btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 0.8rem 1rem;
        }
        
        .brand {
            font-size: 1.6rem;
        }
        
        .nav-links {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .navbar {
            padding: 0.6rem 0.8rem;
        }
        
        .brand {
            font-size: 1.3rem;
        }
        
        .user-name {
            display: none;
        }
        
        .logout-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>