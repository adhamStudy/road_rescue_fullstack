<template>
  <HomeLayout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
      <!-- Enhanced Hero Section with Glassmorphism -->
      <div class="relative py-24 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-100/30 via-transparent to-indigo-100/30"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(59,130,246,0.1),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(99,102,241,0.1),transparent_50%)]"></div>
        
        <div class="container mx-auto px-6 relative z-10">
          <div class="text-center max-w-4xl mx-auto">
            <div class="hero-content">
              <!-- University Logo -->
              <div class="mb-8 floating-element">
                <div class="logo-container">
                  <img 
                  src="/public/assets/images/logo.png" 
                    alt="King Khalid University" 
                    class="h-28 w-28 rounded-full shadow-2xl mx-auto border-4 border-white/50 backdrop-blur-sm logo-hover"
                  />
                  <div class="logo-glow"></div>
                </div>
              </div>
              
              <!-- Title with Typewriter Effect -->
              <h1 class="text-6xl font-bold text-gray-800 mb-6 leading-tight typewriter-text">
                {{ projectInfo.title }}
              </h1>
              
              <!-- Description with Fade In -->
              <p class="text-xl text-gray-600 mb-10 leading-relaxed description-fade max-w-3xl mx-auto">
                {{ projectInfo.description }}
              </p>
              
              <!-- University Badge -->
              <div class="university-badge">
                <svg class="w-6 h-6 text-blue-600 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 font-semibold">{{ projectInfo.university }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Students Section -->
      <div class="py-20 relative">
        <div class="container mx-auto px-6">
          <div class="text-center mb-16 section-header">
            <h2 class="text-5xl font-bold text-gray-800 mb-6">فريق المشروع</h2>
            <div class="section-divider"></div>
            <p class="text-gray-600 text-xl mt-6">الطلاب المبدعون وراء هذا المشروع</p>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            <div 
              v-for="(student, index) in students" 
              :key="student.id"
              class="student-card"
              :style="{ animationDelay: `${index * 200}ms` }"
            >
              <div class="card-content">
                <!-- Avatar with Animation -->
                <div class="mb-6 avatar-container">
                  <div class="student-avatar">
                    {{ student.name.charAt(0) }}
                  </div>
                  <div class="avatar-ring"></div>
                </div>
                
                <!-- Student Info -->
                <h3 class="text-xl font-bold text-gray-800 mb-3 student-name">
                  {{ student.name }}
                </h3>
                
                <div class="student-id">
                  {{ student.id }}
                </div>
                
                <p class="text-gray-600 text-sm leading-relaxed mt-4 student-role">
                  {{ student.role }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced Supervisor Section -->
      <div class="py-20 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-indigo-50/50"></div>
        
        <div class="container mx-auto px-6 relative z-10">
          <div class="text-center mb-16 section-header">
            <h2 class="text-5xl font-bold text-gray-800 mb-6"> Super Visor </h2>
            <div class="section-divider"></div>
          </div>
          
          <div class="max-w-6xl mx-auto">
            <div class="supervisor-card">
              <div class="p-12">
                <div class="flex flex-col lg:flex-row items-center text-center lg:text-right">
                  <!-- Supervisor Avatar -->
                  <div class="mb-8 lg:mb-0 lg:ml-12 flex-shrink-0 supervisor-avatar-container">
                    <div class="supervisor-avatar">
                      {{ supervisor.name.charAt(0) }}
                    </div>
                    <div class="supervisor-avatar-glow"></div>
                  </div>
                  
                  <!-- Supervisor Info -->
                  <div class="flex-1">
                    <h3 class="text-4xl font-bold text-gray-800 mb-4 supervisor-name">
                      {{ supervisor.title }} {{ supervisor.name }}
                    </h3>
                    <p class="text-blue-600 font-semibold text-xl mb-6 supervisor-department">{{ supervisor.department }}</p>
                    <p class="text-gray-600 leading-relaxed text-lg mb-8 supervisor-bio">
                      {{ supervisor.bio }}
                    </p>
                    
                    <!-- Contact Info -->
                    <div class="flex flex-col lg:flex-row items-center justify-center lg:justify-end space-y-4 lg:space-y-0 lg:space-x-8">
                      <div class="contact-info">
                        <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        <span>{{ supervisor.email }}</span>
                      </div>
                      <div class="university-tag">
                        {{ supervisor.university }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Enhanced University Section -->
      <div class="py-20 relative">
        <div class="container mx-auto px-6">
          <div class="text-center max-w-5xl mx-auto">
            <div class="university-card">
              <div class="university-logo-container">
                <img 
                  src="/public/assets/images/khalid.png" 
                  alt="King Khalid University" 
                  class="university-logo"
                />
                <div class="university-logo-glow"></div>
              </div>
              
              <h3 class="text-4xl font-bold text-gray-800 mb-8 university-name">{{ projectInfo.university }}</h3>
              
              <p class="text-gray-600 leading-relaxed text-lg mb-10 university-description">
                نفخر بانتمائنا لجامعة الملك خالد، إحدى الجامعات الرائدة في المملكة العربية السعودية، 
                والتي تسعى لتقديم تعليم متميز وبحث علمي رائد يساهم في خدمة المجتمع وتطوير المعرفة.
              </p>
              
              <div class="location-badge">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-700 font-semibold">أبها، المملكة العربية السعودية</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<script setup>
import HomeLayout from '../Layouts/HomeLayout.vue'
import { ref } from 'vue'

// Project Information (easily editable)
const projectInfo = ref({
  title: " Road Rescue ",
  description: "مشروع تقني متطور يهدف إلى حل المشاكل الحقيقية وتطوير حلول مبتكرة تساهم في تقدم المجتمع التقني",
  university: "جامعة الملك خالد"
})

// Students Data (easily editable object)
const students = ref([
  {
    id: "441200001",
    name: "أحمد محمد العمري",
    role: "مطور الواجهة الأمامية ومصمم تجربة المستخدم"
  },
  {
    id: "441200002", 
    name: "فهد عبدالله السلمي",
    role: "مطور الخادم ومهندس قواعد البيانات"
  },
  {
    id: "441200003",
    name: "سعد عبدالرحمن الغامدي", 
    role: "مختص الأمان السيبراني ومحلل الأنظمة"
  },
  {
    id: "441200004",
    name: "محمد سعد القرني",
    role: "مطور التطبيقات المحمولة ومختبر الجودة"
  }
])

// Supervisor Data (easily editable object)
const supervisor = ref({
  name: "عبدالله أحمد الشهراني",
  title: "الدكتور",
  department: "قسم علوم الحاسب الآلي",
  university: "جامعة الملك خالد", 
  email: "dr.alshahrani@kku.edu.sa",
  bio: "أستاذ مشارك في علوم الحاسب الآلي بخبرة تزيد عن 15 عاماً في مجال الذكاء الاصطناعي وهندسة البرمجيات. حاصل على درجة الدكتوراه من جامعة ستانفورد ولديه أكثر من 50 بحثاً علمياً منشوراً في مجلات عالمية محكمة."
})
</script>

<style scoped>
/* Enhanced Animations */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

@keyframes pulse-glow {
  0%, 100% { opacity: 0.5; transform: scale(1); }
  50% { opacity: 0.8; transform: scale(1.05); }
}

@keyframes slide-up-fade {
  from {
    opacity: 0;
    transform: translateY(50px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes typewriter {
  from { width: 0 }
  to { width: 100% }
}

@keyframes blink {
  0%, 50% { border-color: transparent }
  51%, 100% { border-color: #3b82f6 }
}

@keyframes gradient-shift {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

@keyframes ripple {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  100% {
    transform: scale(4);
    opacity: 0;
  }
}

/* Hero Section Styles */
.hero-content {
  animation: slide-up-fade 1s ease-out;
}

.floating-element {
  animation: float 3s ease-in-out infinite;
}

.logo-container {
  position: relative;
  display: inline-block;
}

.logo-hover {
  transition: all 0.3s ease;
  position: relative;
  z-index: 2;
}

.logo-hover:hover {
  transform: scale(1.1);
  border-color: rgba(59, 130, 246, 0.5);
}

.logo-glow {
  position: absolute;
  top: -10px;
  left: -10px;
  right: -10px;
  bottom: -10px;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulse-glow 2s ease-in-out infinite;
  z-index: 1;
}

.typewriter-text {
  overflow: hidden;
  border-right: 3px solid #3b82f6;
  animation: typewriter 2s steps(20) 0.5s 1 normal both, blink 1s infinite;
  white-space: nowrap;
  margin: 0 auto;
}

.description-fade {
  animation: slide-up-fade 1s ease-out 1s both;
}

.university-badge {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 50px;
  padding: 16px 32px;
  display: inline-flex;
  align-items: center;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  animation: slide-up-fade 1s ease-out 1.5s both;
}

.university-badge:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
  background: rgba(255, 255, 255, 0.9);
}

/* Section Headers */
.section-header {
  animation: slide-up-fade 0.8s ease-out;
}

.section-divider {
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #3b82f6, #8b5cf6);
  margin: 0 auto;
  border-radius: 2px;
  position: relative;
  overflow: hidden;
}

.section-divider::after {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
  animation: gradient-shift 2s ease-in-out infinite;
}

/* Student Cards */
.student-card {
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 24px;
  padding: 32px 24px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  height: 100%;
  min-height: 360px;
  position: relative;
  overflow: hidden;
  animation: slide-up-fade 0.8s ease-out both;
}

.student-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
  background-size: 200% 100%;
  animation: gradient-shift 3s ease-in-out infinite;
}

.student-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  background: rgba(255, 255, 255, 0.85);
  border-color: rgba(59, 130, 246, 0.3);
}

.card-content {
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  position: relative;
  z-index: 2;
}

.avatar-container {
  position: relative;
  display: inline-block;
}

.student-avatar {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 2rem;
  font-weight: bold;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
  position: relative;
  z-index: 2;
}

.avatar-ring {
  position: absolute;
  top: -8px;
  left: -8px;
  right: -8px;
  bottom: -8px;
  border: 2px solid transparent;
  border-radius: 50%;
  background: linear-gradient(45deg, #3b82f6, #8b5cf6) border-box;
  mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
  mask-composite: subtract;
  animation: pulse-glow 2s ease-in-out infinite;
}

.student-card:hover .student-avatar {
  transform: scale(1.1);
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
}

.student-name {
  transition: all 0.3s ease;
}

.student-card:hover .student-name {
  color: #3b82f6;
  transform: translateY(-2px);
}

.student-id {
  background: linear-gradient(135deg, #e0f2fe 0%, #f8fafc 100%);
  color: #0369a1;
  padding: 8px 16px;
  border-radius: 25px;
  font-size: 0.875rem;
  font-weight: 600;
  border: 1px solid #e0f2fe;
  transition: all 0.3s ease;
}

.student-card:hover .student-id {
  background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
  transform: translateY(-2px);
}

.student-role {
  flex: 1;
  display: flex;
  align-items: center;
  transition: all 0.3s ease;
}

/* Supervisor Section */
.supervisor-card {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 32px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  animation: slide-up-fade 0.8s ease-out;
}

.supervisor-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 6px;
  background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4, #10b981);
  background-size: 300% 100%;
  animation: gradient-shift 4s ease-in-out infinite;
}

.supervisor-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
  background: rgba(255, 255, 255, 0.9);
}

.supervisor-avatar-container {
  position: relative;
  display: inline-block;
}

.supervisor-avatar {
  width: 140px;
  height: 140px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 3.5rem;
  font-weight: bold;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
  position: relative;
  z-index: 2;
}

.supervisor-avatar-glow {
  position: absolute;
  top: -15px;
  left: -15px;
  right: -15px;
  bottom: -15px;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.4) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulse-glow 3s ease-in-out infinite;
  z-index: 1;
}

.supervisor-card:hover .supervisor-avatar {
  transform: scale(1.05);
  box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
}

.supervisor-name {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  transition: all 0.3s ease;
}

.supervisor-department {
  transition: all 0.3s ease;
}

.supervisor-card:hover .supervisor-department {
  transform: translateY(-2px);
  color: #4f46e5;
}

.supervisor-bio {
  transition: all 0.3s ease;
}

.contact-info {
  display: flex;
  align-items: center;
  color: #6b7280;
  background: rgba(243, 244, 246, 0.8);
  padding: 12px 20px;
  border-radius: 25px;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
}

.contact-info:hover {
  background: rgba(59, 130, 246, 0.1);
  color: #3b82f6;
  transform: translateY(-2px);
}

.university-tag {
  background: linear-gradient(135deg, #e0f2fe 0%, #f8fafc 100%);
  color: #0369a1;
  padding: 12px 24px;
  border-radius: 25px;
  font-weight: 600;
  border: 1px solid #e0f2fe;
  transition: all 0.3s ease;
}

.university-tag:hover {
  background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(3, 105, 161, 0.2);
}

/* University Section */
.university-card {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 32px;
  padding: 48px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
  animation: slide-up-fade 0.8s ease-out;
}

.university-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: linear-gradient(90deg, #3b82f6, #10b981, #f59e0b, #ef4444);
  background-size: 400% 100%;
  animation: gradient-shift 5s ease-in-out infinite;
}

.university-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
  background: rgba(255, 255, 255, 0.9);
}

.university-logo-container {
  position: relative;
  display: inline-block;
  margin-bottom: 32px;
}

.university-logo {
  height: 100px;
  width: 100px;
  border-radius: 50%;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
  border: 4px solid rgba(255, 255, 255, 0.8);
  transition: all 0.3s ease;
  position: relative;
  z-index: 2;
}

.university-logo-glow {
  position: absolute;
  top: -20px;
  left: -20px;
  right: -20px;
  bottom: -20px;
  background: radial-gradient(circle, rgba(16, 185, 129, 0.3) 0%, transparent 70%);
  border-radius: 50%;
  animation: pulse-glow 2.5s ease-in-out infinite;
  z-index: 1;
}

.university-card:hover .university-logo {
  transform: scale(1.08);
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
}

.university-name {
  background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  transition: all 0.3s ease;
}

.university-description {
  transition: all 0.3s ease;
  max-width: 4xl;
}

.location-badge {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  border-radius: 50px;
  padding: 16px 32px;
  display: inline-flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.location-badge:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
  background: rgba(255, 255, 255, 1);
}

/* Responsive Design */
@media (max-width: 768px) {
  .container {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  
  .text-6xl {
    font-size: 2.5rem;
  }
  
  .text-5xl {
    font-size: 2rem;
  }
  
  .text-4xl {
    font-size: 1.875rem;
  }
  
  .student-card {
    min-height: 320px;
    padding: 24px 20px;
  }
  
  .student-avatar {
    width: 70px;
    height: 70px;
    font-size: 1.75rem;
  }
  
  .supervisor-avatar {
    width: 120px;
    height: 120px;
    font-size: 3rem;
  }
  
  .university-logo {
    height: 80px;
    width: 80px;
  }
  
  .university-card {
    padding: 32px 24px;
  }
  
  .supervisor-card .p-12 {
    padding: 32px 24px;
  }
}

/* RTL Support */
[dir="rtl"] .text-center {
  text-align: center;
}

[dir="rtl"] .lg\:text-right {
  text-align: right;
}

[dir="rtl"] .lg\:justify-end {
  justify-content: flex-end;
}

/* Loading Animation */
@keyframes shimmer {
  0% {
    background-position: -200px 0;
  }
  100% {
    background-position: calc(200px + 100%) 0;
  }
}

.shimmer {
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200px 100%;
  animation: shimmer 1.5s infinite;
}

/* Scroll-triggered animations */
.fade-in-up {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.6s ease-out;
}

.fade-in-up.in-view {
  opacity: 1;
  transform: translateY(0);
}

/* Hover effects for cards */
.student-card::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: all 0.6s ease;
  pointer-events: none;
}

.student-card:hover::after {
  width: 300px;
  height: 300px;
  animation: ripple 0.6s ease-out;
}

/* Enhanced focus states for accessibility */
.student-card:focus,
.supervisor-card:focus,
.university-card:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
}

/* Smooth scroll behavior */
html {
  scroll-behavior: smooth;
}

/* Enhanced text selection */
::selection {
  background: rgba(59, 130, 246, 0.2);
  color: #1e40af;
}

::-moz-selection {
  background: rgba(59, 130, 246, 0.2);
  color: #1e40af;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(135deg, #3b82f6, #8b5cf6);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(135deg, #2563eb, #7c3aed);
}

/* Performance optimizations */
.student-card,
.supervisor-card,
.university-card {
  will-change: transform;
  transform: translateZ(0);
}

/* Enhanced motion for reduced motion preference */
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
  
  .floating-element {
    animation: none;
  }
  
  .typewriter-text {
    animation: none;
    border-right: none;
  }
}

/* Print styles */
@media print {
  .student-card,
  .supervisor-card,
  .university-card {
    box-shadow: none !important;
    border: 1px solid #e5e7eb !important;
    background: white !important;
  }
  
  .section-divider {
    background: #6b7280 !important;
  }
}
</style>