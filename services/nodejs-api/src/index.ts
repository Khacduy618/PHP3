import express, { Request, Response } from "express";
import mongoose from "mongoose";
import * as  dotenv from "dotenv";
// Load biến môi trường từ .env
dotenv.config();

const mongoURI = process.env.MONGO_URI || "";
const PORT = process.env.PORT || 5000;

if (!mongoURI) {
  console.error("❌ Không tìm thấy MONGO_URI trong .env!");
  process.exit(1);
}


// Kết nối MongoDB
mongoose
  .connect(mongoURI)
  .then(() => {
    console.log("✅ Kết nối MongoDB thành công!");
    startServer();
  })
  .catch((error) => {
    console.error("❌ Lỗi kết nối MongoDB:", error.message);
    process.exit(1);
  });

// Tạo Schema & Model
const userSchema = new mongoose.Schema({
  name: String,
  email: String,
  age: Number,
});

const User = mongoose.model("users", userSchema); // "users" là tên collection trong MongoDB

// Khởi chạy server Express
function startServer() {
  const app = express();

  // Route để lấy danh sách users dưới dạng JSON
  app.get("/users", async (req: Request, res: Response) => {
    try {
      const users = await User.find(); // Lấy toàn bộ dữ liệu từ collection "users"
      res.json(users); // Trả về dữ liệu dưới dạng JSON
    } catch (error) {
      res.status(500).json({ message: "Lỗi server!", error });
    }
  });
  app.get("/", (req:Request, res:Response) => {
  res.send("hello bạn");
  });
  app.listen(PORT, () => {
    console.log(`🚀 Server chạy tại http://localhost:${PORT}`);
  });
}
