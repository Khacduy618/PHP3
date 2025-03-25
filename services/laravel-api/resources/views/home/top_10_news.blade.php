<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buletin - News Portal</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Custom styling -->
  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f5f5f5;
    }
    .buletin-red {
      color: #e63946;
    }
    .bg-buletin-red {
      background-color: #e63946;
    }
    .nav-link {
      position: relative;
    }
    .nav-link.active:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 100%;
      height: 2px;
      background-color: #e63946;
    }
    .card {
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }
    .story-circle {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      overflow: hidden;
      margin: 0 auto;
    }
    .story-circle img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .story-name {
      font-size: 0.8rem;
      text-align: center;
      margin-top: 0.5rem;
    }
    .read-time {
      color: #718096;
      font-size: 0.8rem;
    }
    .category-tag {
      font-size: 0.7rem;
      padding: 0.2rem 0.5rem;
      border-radius: 3px;
      color: #fff;
    }
    .bg-movies {
      background-color: #e63946;
    }
    .bg-sports {
      background-color: #1d3557;
    }
    .bg-news {
      background-color: #457b9d;
    }
    .bg-tech {
      background-color: #2a9d8f;
    }
    .bg-business {
      background-color: #e76f51;
    }
    .bg-entertainment {
      background-color: #9b5de5;
    }
  </style>
</head>
<body class="bg-gray-100">
  <!-- Header Navigation -->
  <header class="bg-white container shadow-sm sticky top-0 z-50 mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <h1 class="text-2xl font-bold buletin-red mr-8">Buletin</h1>
          <nav class="hidden md:flex space-x-6">
            <a href="#" class="nav-link active font-medium">Stories</a>
            <a href="#" class="nav-link font-medium">Creator</a>
            <a href="#" class="nav-link font-medium">Community</a>
            <a href="#" class="nav-link font-medium">Subscribe</a>
          </nav>
        </div>
        <div class="flex items-center space-x-4">
          <button class="hidden md:block border border-gray-300 rounded-full px-4 py-2 text-sm font-medium">Write</button>
          <button class="text-gray-600"><i class="fas fa-search"></i></button>
          <button class="text-gray-600"><i class="fas fa-bell"></i></button>
          <button class="w-8 h-8 rounded-full bg-gray-300 overflow-hidden">
            <img src="https://via.placeholder.com/32" alt="Profile" class="w-full h-full object-cover">
          </button>
        </div>
      </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-6">
    <!-- Welcome Banner -->
    <section class="bg-gray-100 rounded-lg p-6 text-center mb-8">
      <h2 class="text-gray-500 text-sm tracking-widest uppercase mb-2">WELCOME TO BULETIN</h2>
      <h3 class="text-2xl font-bold">
        Craft narratives ✍️ that ignite 
        <span class="buletin-red">inspiration</span>, 
        <span class="text-blue-600">knowledge</span>, and 
        <span class="text-yellow-500">entertainment</span> 🍿
      </h3>
    </section>

    <!-- Featured Article -->
    <section class="mb-12">
      <div class="grid md:grid-cols-5 gap-6">
        <div class="md:col-span-3">
          <div class="relative overflow-hidden rounded-lg shadow-md h-full">
            <img src="https://via.placeholder.com/800x450" alt="John Wick 4" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
              <div class="flex items-center mb-2">
                <div class="w-6 h-6 rounded-full bg-gray-300 overflow-hidden mr-2">
                  <img src="https://via.placeholder.com/24" alt="Author" class="w-full h-full object-cover">
                </div>
                <span class="text-white text-xs">Buletin</span>
                <span class="text-gray-300 text-xs ml-2">• 12 minutes ago</span>
              </div>
              <h2 class="text-2xl font-bold text-white mb-2">Where To Watch 'John Wick: Chapter 4'</h2>
              <p class="text-gray-200 text-sm">After the events of the previous film, John Wick: Chapter 4's streaming release "However, given it's a Lionsgate film, John Wick: Chapter 4 will eventually be released on Starz..."</p>
              <div class="flex items-center mt-3">
                <span class="category-tag bg-movies mr-3">Movies</span>
                <span class="text-gray-300 text-xs">• 4 min read</span>
              </div>
            </div>
          </div>
        </div>
        <div class="md:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-6 h-full">
            <div class="section-header">
              <h2 class="text-xl font-bold">Latest News</h2>
              <a href="#" class="text-sm buletin-red">See all →</a>
            </div>
            <div class="space-y-4">
              <!-- News items -->
              <div class="flex items-start space-x-3">
                <div class="w-20 h-20 rounded overflow-hidden flex-shrink-0">
                  <img src="https://via.placeholder.com/80" alt="News" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                  <div class="flex items-center mb-1">
                    <span class="category-tag bg-sports text-xs mr-2">Sports</span>
                    <span class="text-gray-500 text-xs">• April 12, 2023</span>
                  </div>
                  <h3 class="font-medium text-sm mb-1">'He deserves a lot more': Verstappen backs teammate</h3>
                  <p class="text-gray-500 text-xs mb-1">Max Verstappen believes his fellow Red Bull driver is deserving of more credit...</p>
                  <div class="flex items-center">
                    <span class="text-gray-500 text-xs">Sport</span>
                    <span class="text-gray-400 text-xs mx-1">•</span>
                    <span class="text-gray-500 text-xs">6 min read</span>
                  </div>
                </div>
              </div>
              
              <div class="flex items-start space-x-3">
                <div class="w-20 h-20 rounded overflow-hidden flex-shrink-0">
                  <img src="https://via.placeholder.com/80" alt="News" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                  <div class="flex items-center mb-1">
                    <span class="category-tag bg-sports text-xs mr-2">Sports</span>
                    <span class="text-gray-500 text-xs">• April 12, 2023</span>
                  </div>
                  <h3 class="font-medium text-sm mb-1">Liverpool hammer rivals for first win in Premier League</h3>
                  <p class="text-gray-500 text-xs mb-1">Mohamed Salah and Diogo Jota both scored twice as Liverpool crushed...</p>
                  <div class="flex items-center">
                    <span class="text-gray-500 text-xs">Sport</span>
                    <span class="text-gray-400 text-xs mx-1">•</span>
                    <span class="text-gray-500 text-xs">5 min read</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Buletin Stories -->
    <section class="mb-12">
      <div class="section-header">
        <h2 class="text-xl font-bold">Buletin Story</h2>
        <a href="#" class="text-sm buletin-red">See all →</a>
      </div>
      <div class="grid grid-cols-5 sm:grid-cols-7 md:grid-cols-10 gap-4">
        <div class="flex flex-col items-center">
          <div class="story-circle border-2 border-red-500">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Movies</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Business</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Formula One</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Global Issues</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Tech</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Apple</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Samsung</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Opinion</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Jonathan</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="story-circle">
            <img src="https://via.placeholder.com/60" alt="Story">
          </div>
          <p class="story-name">Roy</p>
        </div>
      </div>
    </section>

    <!-- Must Read Section -->
    <section class="mb-12">
      <div class="section-header">
        <h2 class="text-xl font-bold">Must Read</h2>
        <a href="#" class="text-sm buletin-red">See all →</a>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="col-span-1">
          <div class="bg-white rounded-lg shadow-md overflow-hidden h-full">
            <img src="https://via.placeholder.com/400x250" alt="Ukraine" class="w-full h-48 object-cover">
            <div class="p-4">
              <div class="flex items-center mb-2">
                <span class="category-tag bg-news text-xs mr-2">News</span>
                <span class="text-gray-500 text-xs">• April 11, 2023</span>
              </div>
              <h3 class="font-bold text-lg mb-2">Ukraine's silence along southern front fuels offensive rumors</h3>
              <p class="text-gray-600 text-sm mb-3">Dispatching medics rather than soldiers to a newly created military unit near the front line is the latest sign...</p>
              <div class="flex items-center">
                <span class="text-gray-500 text-xs">War</span>
                <span class="text-gray-400 text-xs mx-1">•</span>
                <span class="text-gray-500 text-xs">8 min read</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-span-2">
          <div class="bg-white rounded-lg shadow-md overflow-hidden h-full">
            <div class="grid md:grid-cols-2 h-full">
              <div class="p-6 flex flex-col justify-center">
                <div class="flex items-center mb-2">
                  <span class="category-tag bg-entertainment text-xs mr-2">Music</span>
                  <span class="text-gray-500 text-xs">• April 12, 2023</span>
                </div>
                <h3 class="font-bold text-xl mb-3">Taylor Swift is sending a powerful message to women on the Era's tour</h3>
                <p class="text-gray-600 text-sm mb-4">Like "We are never ever getting back together," which sounds like a breakup anthem but is actually about the decision Swift made...</p>
                <div class="flex items-center">
                  <span class="text-gray-500 text-xs">Entertainment</span>
                  <span class="text-gray-400 text-xs mx-1">•</span>
                  <span class="text-gray-500 text-xs">10 min read</span>
                </div>
              </div>
              <div class="bg-gray-200">
                <img src="https://via.placeholder.com/400x300" alt="Taylor Swift" class="w-full h-full object-cover">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Editor's Pick -->
    <section class="mb-12">
      <div class="section-header">
        <h2 class="text-xl font-bold">Editor's Pick</h2>
        <a href="#" class="text-sm buletin-red">See all →</a>
      </div>
      <div class="mb-6">
        <div class="relative overflow-hidden rounded-lg shadow-md">
          <img src="https://via.placeholder.com/1200x400" alt="iPhone 15" class="w-full h-80 object-cover">
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6">
            <div class="flex items-center mb-2">
              <div class="w-6 h-6 rounded-full bg-gray-300 overflow-hidden mr-2">
                <img src="https://via.placeholder.com/24" alt="Author" class="w-full h-full object-cover">
              </div>
              <span class="text-white text-xs">Buletin</span>
              <span class="text-gray-300 text-xs ml-2">• 12 minutes ago</span>
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">All the rumors about the iPhone 15, expected in 2023</h2>
            <p class="text-gray-200 text-sm">Apple is reportedly changing the design for the iPhone 15 and all its models, but we're very likely waiting until the latter iPhone 15 models actually become available for purchase...</p>
            <div class="flex items-center mt-3">
              <span class="category-tag bg-tech mr-3">Technology</span>
              <span class="text-gray-300 text-xs">• 20 min read</span>
            </div>
          </div>
        </div>
      </div>
      <div class="grid md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://via.placeholder.com/300x200" alt="Beach" class="w-full h-32 object-cover">
          <div class="p-3">
            <div class="flex items-center mb-1">
              <span class="category-tag bg-news text-xs mr-2">Travel</span>
              <span class="text-gray-500 text-xs">• April 12, 2023</span>
            </div>
            <h3 class="font-medium text-sm mb-1">Fiji Air launches direct Macau-Fiji service, welcomes digital...</h3>
            <div class="flex items-center mt-1">
              <span class="text-gray-500 text-xs">Travel</span>
              <span class="text-gray-400 text-xs mx-1">•</span>
              <span class="text-gray-500 text-xs">8 min read</span>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://via.placeholder.com/300x200" alt="Remote work" class="w-full h-32 object-cover">
          <div class="p-3">
            <div class="flex items-center mb-1">
              <span class="category-tag bg-tech text-xs mr-2">Tech</span>
              <span class="text-gray-500 text-xs">• 1 week ago</span>
            </div>
            <h3 class="font-medium text-sm mb-1">ChatGPT: How generative AI could change hiring as we know it</h3>
            <div class="flex items-center mt-1">
              <span class="text-gray-500 text-xs">Work</span>
              <span class="text-gray-400 text-xs mx-1">•</span>
              <span class="text-gray-500 text-xs">10 min read</span>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://via.placeholder.com/300x200" alt="Twitter" class="w-full h-32 object-cover">
          <div class="p-3">
            <div class="flex items-center mb-1">
              <span class="category-tag bg-tech text-xs mr-2">Tech</span>
              <span class="text-gray-500 text-xs">• 2 hours ago</span>
            </div>
            <h3 class="font-medium text-sm mb-1">Twitter gives fake accounts blue check verified status...</h3>
            <div class="flex items-center mt-1">
              <span class="text-gray-500 text-xs">Technology</span>
              <span class="text-gray-400 text-xs mx-1">•</span>
              <span class="text-gray-500 text-xs">5 min read</span>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="https://via.placeholder.com/300x200" alt="Book" class="w-full h-32 object-cover">
          <div class="p-3">
            <div class="flex items-center mb-1">
              <span class="category-tag bg-news text-xs mr-2">News</span>
              <span class="text-gray-500 text-xs">• 10 hours ago</span>
            </div>
            <h3 class="font-medium text-sm mb-1">First edition Shakespeare book from 1623 goes on display...</h3>
            <div class="flex items-center mt-1">
              <span class="text-gray-500 text-xs">Culture</span>
              <span class="text-gray-400 text-xs mx-1">•</span>
              <span class="text-gray-500 text-xs">6 min read</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Business & Sport News -->
    <div class="grid md:grid-cols-2 gap-8 mb-12">
      <!-- Business News -->
      <section>
        <div class="section-header">
          <h2 class="text-xl font-bold">Business</h2>
          <a href="#" class="text-sm buletin-red">See all →</a>
        </div>
        <div class="grid grid-cols-1 gap-4">
          <div class="flex items-start space-x-3">
            <div class="w-20 h-20 rounded overflow-hidden flex-shrink-0">
              <img src="https://via.placeholder.com/80" alt="Business" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
              <div class="flex items-center mb-1">
                <span class="category-tag bg-business text-xs mr-2">Tech</span>
                <span class="text-gray-500 text-xs">• 5 hours ago</span>
              </div>
              <h3 class="font-medium text-sm mb-1">Fresh producers turn to new AI tactic in crops of farm farming</h3>
              <div class="flex items-center">
                <span class="text-gray-500 text-xs">Business</span>
                <span class="text-gray-400 text-xs mx-1">•</span>
                <span class="text-gray-500 text-xs">7 min read</span>
              </div>
            </div>
          </div>
          
          <div class="flex items-start space-x-3">
            <div class="w-20 h-20 rounded overflow-hidden flex-shrink-0">
              <img src="https://via.placeholder.com/80" alt="Business" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
              <div class="flex items-center mb-1">
                <span class="category-tag bg-business text-xs mr-2">HR</span>
                <span class="text-gray-500 text-xs">• 7 hours ago</span>
              </div>
              <h3 class="font-medium text-sm mb-1">Low employee engagement? Managers can help turn it around</h3>
              <div class="flex items-center">
                <span class="text-gray-500 text-xs">Work</span>
                <span class="text-gray-400 text-xs mx-1">•</span>
                <span class="text-gray-500 text-xs">8 min read</span>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Sport News -->
      <section>
        <div class="section-header">
          <h2 class="text-xl font-bold">Sport News</h2>
          <a href="#" class="text-sm buletin-red">See all →</a>
        </div>
        <div class="grid grid-cols-1 gap-4">
          <div class="flex items-start space-x-3">
            <div class="w-20 h-20 rounded overflow-hidden flex-shrink-0">
              <img src="https://via.placeholder.com/80" alt="Sport" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
              <div class="flex items-center mb-1">
                <span class="category-tag bg-sports text-xs mr-2">Golf</span>
                <span class="text-gray-500 text-xs">• 3 hours ago</span>
              </div>
              <h3 class="font-medium text-sm mb-1">'You need to stop': Golfers take a plea to save ball tampering</h3>
              <div class="flex items-center">
                <span class="text-gray-500 text-xs">Sport</span>
                <span class="text-gray-400 text-xs mx-1">•</span>
                <span class="text-gray-500 text-xs">6 min read</span>
              </div>
            </div>
          </div>
          
          <div class="flex items-start space-x-3">
            <div class="w-20 h-20 rounded overflow-hidden flex-shrink-0">
              <img src="https://via.placeholder.com/80" alt="Sport" class="w-full h-full object-cover">
            </div>
            <div class="flex-1">
              <div class="flex items-center mb-1">
                <span class="category-tag bg-sports text-xs mr-2">Tennis</span>
                <span class="text-gray-500 text-xs">• 12 hours ago</span>
              </div>
              <h3 class="font-medium text-sm mb-1">Emma Raducanu's former coach Dmitry Tursunov opens up on...</h3>
              <div class="flex items-center">
                <span class="text-gray-500 text-xs">Tennis</span>
                <span class="text-gray-400 text-xs mx-1">•</span>
                <span class="text-gray-500 text-xs">9 min read</span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Top Creators -->
    <section class="mb-12">
      <div class="section-header">
        <h2 class="text-xl font-bold">Top Creator</h2>
        <a href="#" class="text-sm buletin-red">See all →</a>
      </div>
      <div class="grid grid-cols-4 sm:grid-cols-4 gap-6">
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 rounded-full overflow-hidden mb-2">
            <img src="https://via.placeholder.com/64" alt="Creator" class="w-full h-full object-cover">
          </div>
          <h3 class="font-medium text-sm text-center">Alex Young</h3>
          <p class="text-gray-500 text-xs">BBC News</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 rounded-full overflow-hidden mb-2">
            <img src="https://via.placeholder.com/64" alt="Creator" class="w-full h-full object-cover">
          </div>
          <h3 class="font-medium text-sm text-center">Joe Alan</h3>
          <p class="text-gray-500 text-xs">CNN</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 rounded-full overflow-hidden mb-2">
            <img src="https://via.placeholder.com/64" alt="Creator" class="w-full h-full object-cover">
          </div>
          <h3 class="font-medium text-sm text-center">Alexa Timber</h3>
          <p class="text-gray-500 text-xs">Freelance</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-16 h-16 rounded-full overflow-hidden mb-2">
            <img src="https://via.placeholder.com/64" alt="Creator" class="w-full h-full object-cover">
          </div>
          <h3 class="font-medium text-sm text-center">Asley Star</h3>
          <p class="text-gray-500 text-xs">BBC</p>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="bg-gray-100 rounded-lg p-6 mb-12">
      <h2 class="text-gray-500 text-sm tracking-widest uppercase mb-4 text-center">GET FIRST UPDATE</h2>
      <h3 class="text-xl font-medium text-center mb-6">
        Get the news in front line by <br>
        <span class="font-bold buletin-red">subscribe</span> for our latest updates
      </h3>
      <div class="flex max-w-md mx-auto">
        <input type="email" placeholder="Your email" class="flex-1 py-2 px-4 rounded-l-lg border-0 focus:ring-2 focus:ring-red-500">        <button class="bg-buletin-red text-white font-medium py-2 px-4 rounded-r-lg">Subscribe</button>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-white pt-12 pb-6 border-t">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-5 gap-8 mb-12">
        <!-- Buletin Info -->
        <div class="col-span-1">
          <h2 class="text-xl font-bold buletin-red mb-4">Buletin</h2>
          <p class="text-gray-600 text-sm mb-4">Crafting narratives that inspire, share knowledge, and entertain</p>
          <div class="flex space-x-3">
            <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="#" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
              <i class="fab fa-pinterest"></i>
            </a>
          </div>
        </div>

        <!-- Business -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Business</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Global</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Economy</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Markets</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Industries</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Startup</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Money</a></li>
          </ul>
        </div>

        <!-- Technology -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Technology</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Mobile</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Gadget</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Internet</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Innovation</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Artificial Intelligence</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Future Tech</a></li>
          </ul>
        </div>

        <!-- Travel -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Travel</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Destinations</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Food & Drink</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">News</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Stay</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Videos</a></li>
          </ul>
        </div>

        <!-- Sports -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Sports</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Tennis</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Golf</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Football</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Basketball</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Baseball</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Formula 1</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Cricket</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Esports</a></li>
          </ul>
        </div>
      </div>
      
      <div class="grid md:grid-cols-5 gap-8 mb-12">
        <!-- Entertainment -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Entertainment</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Movies</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Celebrities</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Television</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Music</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Hollywood</a></li>
          </ul>
        </div>

        <!-- Features -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Features</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Arts</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Design</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Fashion</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Personal Projects</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Foods</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Luxury</a></li>
          </ul>
        </div>

        <!-- Weather -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">Weather</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Climate</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Storm Tracker</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Wildfire</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Environment</a></li>
          </ul>
        </div>

        <!-- More -->
        <div class="col-span-1">
          <h3 class="font-bold text-gray-800 mb-4">More</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Design</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Energy</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Architecture</a></li>
            <li><a href="#" class="text-gray-600 text-sm hover:text-red-500">Work for Buletin</a></li>
          </ul>
        </div>
      </div>

      <!-- Copyright -->
      <div class="text-center pt-8 border-t">
        <p class="text-gray-500 text-sm">Copyright © 2023 Buletin.</p>
      </div>
    </div>
  </footer>

  <!-- jQuery interactions -->
  <script>
    $(document).ready(function() {
      // Hover effects for cards
      $('.card').hover(
        function() {
          $(this).addClass('shadow-lg');
        },
        function() {
          $(this).removeClass('shadow-lg');
        }
      );

      // Story circle click handler
      $('.story-circle').click(function() {
        $('.story-circle').removeClass('border-2 border-red-500');
        $(this).addClass('border-2 border-red-500');
      });

      // Smooth scroll for anchor links
      $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
          scrollTop: $($(this).attr('href')).offset().top - 100
        }, 500);
      });

      // Mobile menu toggle
      $('.mobile-menu-toggle').on('click', function() {
        $('.mobile-menu').toggleClass('hidden');
      });

      // Initialize tooltip
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
</body>
</html>