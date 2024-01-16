# B2B Taxi Booking Web Application

Welcome to our B2B Taxi Booking Web Application repository! This application is built using the Laravel framework and is designed specifically for business-to-business taxi bookings.

## Demo Video
[![Demo Video](https://img.youtube.com/vi/cKS0pCEyCmA/0.jpg)](https://youtu.be/cKS0pCEyCmA)

## Credentials
Please check console after db::seed command for Dummy credentials of Admin, Drivers and Partners

## Features

- **User-friendly Interface:** Easily book taxis for your business needs through a simple and intuitive interface.

- **B2B Booking:** Tailored for business users, allowing efficient and seamless booking processes.

- **Secure Authentication:** Ensure the security of your business data with robust user authentication.

- **Real-time Tracking:** Track the location of your booked taxis in real-time, ensuring accurate and timely arrivals.

- **Customized Reports:** Generate customized reports for your business travel expenses and usage.

## Getting Started

Follow these steps to set up and run the B2B Taxi Booking Web Application locally:

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/mnadeemasghar/BookingBackEnd.git
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   ```

3. **Copy Environment File:**
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Configure Database:**
   Update the `.env` file with your database connection details.

6. **Run Migrations and database seeder:**
   ```bash
   php artisan migrate --seed
   ```

7. **Serve the Application:**
   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` in your browser to access the B2B Taxi Booking Web Application.

## Contributing

We welcome contributions from the community! If you'd like to contribute, please follow our [Contribution Guidelines](CONTRIBUTING.md).

## License

This B2B Taxi Booking Web Application is open-source and licensed under the [MIT License](LICENSE).

 
