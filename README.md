# Platinum Industrial Employee Portal

A PHP-based employee portal for Platinum Industrial, Inc.

## Railway Deployment

This application is configured for deployment on Railway.

### Environment Variables

Set these environment variables in your Railway project:

- `DB_HOST` - Database host (provided by Railway MySQL addon)
- `DB_USER` - Database username (provided by Railway MySQL addon)
- `DB_PASSWORD` - Database password (provided by Railway MySQL addon)
- `DB_NAME` - Database name (provided by Railway MySQL addon)

### Local Development

For local development, the application will fall back to local database settings.

### Database Setup

1. Add a MySQL database to your Railway project
2. Railway will automatically provide the database connection variables
3. Import your existing database schema and data

### Deployment Steps

1. Connect your GitHub repository to Railway
2. Add a MySQL database service
3. Deploy the application
4. The application will automatically use the Railway-provided database credentials

