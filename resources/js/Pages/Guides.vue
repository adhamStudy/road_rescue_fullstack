<template>
  <HomeLayout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
      <!-- Hero Section -->
      <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
          <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mb-8 shadow-2xl">
              <span class="text-3xl">🛠️</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent mb-6">
              دليل المستخدم الشامل
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
              كل ما تحتاج معرفته لاستخدام منصة خدمات السيارات<br>
              <span class="text-blue-600 font-semibold">بأفضل طريقة ممكنة</span>
            </p>
          </div>
        </div>
      </div>

      <!-- Navigation Pills -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-2 shadow-xl border border-white/20">
          <nav class="flex flex-wrap justify-center gap-2" dir="rtl">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="[
                'group relative px-6 py-4 rounded-2xl font-semibold text-sm transition-all duration-300 hover:scale-105',
                activeTab === tab.id
                  ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-xl shadow-blue-500/25'
                  : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
              ]"
            >
              <span class="relative z-10 flex items-center gap-2">
                <span class="text-lg">{{ tab.icon }}</span>
                <span>{{ tab.name }}</span>
              </span>
              <div v-if="activeTab === tab.id" 
                   class="absolute inset-0 bg-gradient-to-r from-blue-400 to-purple-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-40 transition-opacity"></div>
            </button>
          </nav>
        </div>
      </div>

      <!-- Content Container -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden">
          
          <!-- Before Service Tab -->
          <div v-show="activeTab === 'before'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-400 to-cyan-500 rounded-2xl mb-6 shadow-lg">
                <span class="text-2xl">📱</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                قبل طلب الخدمة
              </h2>
              <p class="text-xl text-gray-600">الاستعداد الصحيح يضمن خدمة أفضل وأسرع</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8">
              <!-- Safety First -->
              <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-red-50 to-pink-50 border border-red-200/50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300">
                  <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                      <span class="text-2xl">🚨</span>
                    </div>
                    <h3 class="text-2xl font-bold text-red-800">الأمان أولاً</h3>
                  </div>
                  <div class="space-y-4">
                    <div v-for="item in safetyItems" :key="item" 
                         class="flex items-center justify-end group/item">
                      <span class="text-red-700 font-medium">{{ item }}</span>
                      <div class="mr-4 w-6 h-6 bg-red-100 rounded-full flex items-center justify-center group-hover/item:bg-red-200 transition-colors">
                        <span class="text-red-600 text-sm">✓</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Required Documents -->
              <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200/50 rounded-3xl p-8 hover:shadow-2xl transition-all duration-300">
                  <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                      <span class="text-2xl">📋</span>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-800">الوثائق المطلوبة</h3>
                  </div>
                  <div class="grid grid-cols-1 gap-6">
                    <div class="space-y-3">
                      <h4 class="font-bold text-blue-700 text-right flex items-center justify-end">
                        وثائق السيارة
                        <span class="mr-2 text-lg">🚗</span>
                      </h4>
                      <div class="space-y-2">
                        <div v-for="doc in carDocuments" :key="doc" 
                             class="bg-white/80 backdrop-blur-sm rounded-xl p-3 text-right text-blue-600 font-medium border border-blue-100 hover:border-blue-200 transition-colors">
                          {{ doc }}
                        </div>
                      </div>
                    </div>
                    <div class="space-y-3">
                      <h4 class="font-bold text-blue-700 text-right flex items-center justify-end">
                        معلومات إضافية
                        <span class="mr-2 text-lg">ℹ️</span>
                      </h4>
                      <div class="space-y-2">
                        <div v-for="info in additionalInfo" :key="info" 
                             class="bg-white/80 backdrop-blur-sm rounded-xl p-3 text-right text-blue-600 font-medium border border-blue-100 hover:border-blue-200 transition-colors">
                          {{ info }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Request Service Tab -->
          <div v-show="activeTab === 'request'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl mb-6 shadow-lg">
                <span class="text-2xl">🔧</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                كيفية طلب الخدمة
              </h2>
              <p class="text-xl text-gray-600">خطوات بسيطة للحصول على المساعدة بسرعة</p>
            </div>

            <!-- Steps Timeline -->
            <div class="relative mb-12">
              <div class="absolute right-8 top-0 bottom-0 w-1 bg-gradient-to-b from-purple-400 to-pink-500 rounded-full"></div>
              <div class="space-y-8">
                <div v-for="(step, index) in serviceSteps" :key="index" 
                     class="group relative">
                  <div class="flex items-start space-x-6 space-x-reverse">
                    <div class="relative">
                      <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                        <span class="text-white font-bold text-xl">{{ index + 1 }}</span>
                      </div>
                      <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    </div>
                    <div class="flex-1 bg-white/80 backdrop-blur-sm rounded-3xl p-8 border border-purple-100 group-hover:shadow-2xl group-hover:border-purple-200 transition-all duration-300">
                      <h3 class="text-2xl font-bold text-gray-900 mb-3 text-right">{{ step.title }}</h3>
                      <p class="text-lg text-gray-600 mb-4 text-right">{{ step.description }}</p>
                      <div class="space-y-2">
                        <div v-for="detail in step.details" :key="detail" 
                             class="bg-purple-50 rounded-xl p-3 text-right text-purple-700 border border-purple-100">
                          • {{ detail }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Service Types Grid -->
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 border border-purple-200/50">
              <h3 class="text-3xl font-bold text-center text-gray-900 mb-8">
                🛠️ أنواع الخدمات المتاحة
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="service in serviceTypes" :key="service.name"
                     class="group relative">
                  <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
                  <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-white/50 group-hover:shadow-2xl group-hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                      <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-2xl">{{ service.icon }}</span>
                      </div>
                      <h4 class="text-xl font-bold text-gray-900 mb-2">{{ service.name }}</h4>
                      <p class="text-gray-600">{{ service.description }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Waiting Tab -->
          <div v-show="activeTab === 'waiting'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-amber-400 to-orange-500 rounded-2xl mb-6 shadow-lg">
                <span class="text-2xl">⏱️</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                انتظار الفني
              </h2>
              <p class="text-xl text-gray-600">ما يمكن توقعه وكيفية الاستعداد</p>
            </div>

            <!-- Expectations Cards -->
            <div class="grid lg:grid-cols-3 gap-8 mb-12">
              <div v-for="expectation in expectations" :key="expectation.title"
                   class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 border border-amber-200/50 hover:shadow-2xl transition-all duration-300">
                  <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-400 to-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                      <span class="text-3xl">{{ expectation.icon }}</span>
                    </div>
                    <h4 class="text-2xl font-bold text-amber-800 mb-3">{{ expectation.title }}</h4>
                    <p class="text-lg text-amber-700">{{ expectation.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Do's and Don'ts -->
            <div class="grid lg:grid-cols-2 gap-8">
              <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-8 border border-emerald-200/50 hover:shadow-2xl transition-all duration-300">
                  <h3 class="text-2xl font-bold text-emerald-800 mb-6 text-right flex items-center justify-end">
                    افعل
                    <span class="mr-3 text-3xl">✅</span>
                  </h3>
                  <div class="space-y-4">
                    <div v-for="item in dosList" :key="item" 
                         class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-right text-emerald-700 font-medium border border-emerald-100 hover:border-emerald-200 transition-colors">
                      • {{ item }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl p-8 border border-red-200/50 hover:shadow-2xl transition-all duration-300">
                  <h3 class="text-2xl font-bold text-red-800 mb-6 text-right flex items-center justify-end">
                    لا تفعل
                    <span class="mr-3 text-3xl">❌</span>
                  </h3>
                  <div class="space-y-4">
                    <div v-for="item in dontsList" :key="item" 
                         class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-right text-red-700 font-medium border border-red-100 hover:border-red-200 transition-colors">
                      • {{ item }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- During Service Tab -->
          <div v-show="activeTab === 'during'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-2xl mb-6 shadow-lg">
                <span class="text-2xl">👨‍🔧</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                أثناء تقديم الخدمة
              </h2>
              <p class="text-xl text-gray-600">كيفية التعامل مع الفني والحصول على أفضل خدمة</p>
            </div>

            <!-- Verification Process -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl p-8 mb-12 border border-indigo-200/50">
              <h3 class="text-3xl font-bold text-indigo-800 mb-8 text-center">
                🔍 التحقق من هوية الفني
              </h3>
              <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                  <h4 class="text-xl font-bold text-indigo-700 text-right">تحقق من:</h4>
                  <div class="space-y-3">
                    <div v-for="item in verificationItems" :key="item" 
                         class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-right text-indigo-700 font-medium border border-indigo-100 hover:shadow-lg transition-all">
                      • {{ item }}
                    </div>
                  </div>
                </div>
                <div class="space-y-4">
                  <h4 class="text-xl font-bold text-indigo-700 text-right">اطلب معرفة:</h4>
                  <div class="space-y-3">
                    <div v-for="item in requestItems" :key="item" 
                         class="bg-white/80 backdrop-blur-sm rounded-xl p-4 text-right text-indigo-700 font-medium border border-indigo-100 hover:shadow-lg transition-all">
                      • {{ item }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Action Grid -->
            <div class="grid md:grid-cols-3 gap-8">
              <div v-for="action in duringServiceActions" :key="action.title"
                   class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-white/50 hover:shadow-2xl transition-all duration-300">
                  <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-2xl flex items-center justify-center mx-auto shadow-lg">
                      <span class="text-2xl">{{ action.icon }}</span>
                    </div>
                  </div>
                  <h4 class="text-xl font-bold text-gray-900 mb-4 text-right">{{ action.title }}</h4>
                  <div class="space-y-2">
                    <div v-for="item in action.items" :key="item" 
                         class="text-gray-600 text-right text-sm">
                      • {{ item }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Tab -->
          <div v-show="activeTab === 'payment'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-2xl mb-6 shadow-lg">
                <span class="text-2xl">💳</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                الدفع وإنهاء الخدمة
              </h2>
              <p class="text-xl text-gray-600">طرق الدفع الآمنة وإجراءات إنهاء الخدمة</p>
            </div>

            <!-- Payment Methods -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-8 mb-12 border border-emerald-200/50">
              <h3 class="text-3xl font-bold text-emerald-800 mb-8 text-center">
                💰 طرق الدفع المقبولة
              </h3>
              <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="method in paymentMethods" :key="method.name"
                     class="group relative">
                  <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-20 transition-opacity"></div>
                  <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-white/50 hover:shadow-xl hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                      <div class="text-4xl mb-3">{{ method.icon }}</div>
                      <h4 class="font-bold text-gray-900 mb-1 text-sm">{{ method.name }}</h4>
                      <p class="text-xs text-gray-600">{{ method.description }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Before and After Payment -->
            <div class="grid lg:grid-cols-2 gap-8">
              <div class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <div class="relative bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 border border-amber-200/50 hover:shadow-2xl transition-all duration-300">
                  <h3 class="text-2xl font-bold text-amber-800 mb-6 text-right">قبل الدفع:</h3>
                  <div class="space-y-4">
                    <div v-for="item in beforePaymentItems" :key="item.text" 
                         class="flex items-center justify-end bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-amber-100 hover:border-amber-200 transition-colors">
                      <span class="text-amber-700 font-medium">{{ item.text }}</span>
                      <span class="mr-3 text-2xl">{{ item.icon }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="grid gap-6">
                <div class="group relative">
                  <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                  <div class="relative bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-200/50 hover:shadow-xl transition-all duration-300">
                    <h4 class="text-lg font-bold text-blue-700 mb-4 text-right">في التطبيق:</h4>
                    <div class="space-y-2">
                      <div v-for="item in appActions" :key="item" 
                           class="text-blue-600 text-right text-sm bg-white/80 rounded-lg p-2 border border-blue-100">
                        • {{ item }}
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="group relative">
                  <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                  <div class="relative bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-200/50 hover:shadow-xl transition-all duration-300">
                    <h4 class="text-lg font-bold text-purple-700 mb-4 text-right">للمتابعة:</h4>
                    <div class="space-y-2">
                      <div v-for="item in followUpActions" :key="item" 
                           class="text-purple-600 text-right text-sm bg-white/80 rounded-lg p-2 border border-purple-100">
                        • {{ item }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Emergency Tab -->
          <div v-show="activeTab === 'emergency'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-red-500 to-pink-600 rounded-2xl mb-6 shadow-lg animate-pulse">
                <span class="text-2xl">🚨</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-4">
                حالات الطوارئ
              </h2>
              <p class="text-xl text-gray-600">إجراءات السلامة والتعامل مع المواقف الطارئة</p>
            </div>

            <!-- Emergency Contacts -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl p-8 mb-12 border border-red-200/50">
              <h3 class="text-3xl font-bold text-red-800 mb-8 text-center">
                📞 أرقام الطوارئ
              </h3>
              <div class="grid md:grid-cols-3 gap-6">
                <div v-for="contact in emergencyContacts" :key="contact.type"
                     class="group relative">
                  <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-500 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                  <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-white/50 hover:shadow-2xl hover:scale-105 transition-all duration-300">
                    <div class="text-center">
                      <div class="text-4xl mb-4">{{ contact.icon }}</div>
                      <h4 class="text-2xl font-black text-gray-900 mb-2">{{ contact.number }}</h4>
                      <p class="text-lg font-bold text-gray-700 mb-1">{{ contact.type }}</p>
                      <p class="text-sm text-gray-600">{{ contact.when }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Emergency Situations -->
            <div class="space-y-8">
              <h3 class="text-3xl font-bold text-center text-gray-900">المواقف الطارئة</h3>
              <div class="grid gap-8">
                <div v-for="situation in emergencySituations" :key="situation.title"
                     class="group relative">
                  <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-orange-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                  <div class="relative bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-red-200/50 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                      <span class="text-4xl">{{ situation.icon }}</span>
                      <h4 class="text-2xl font-bold text-red-800">{{ situation.title }}</h4>
                    </div>
                    <p class="text-gray-700 mb-6 text-right text-lg">{{ situation.description }}</p>
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-6 border border-red-200/50">
                      <h5 class="font-bold text-red-700 mb-4 text-right text-xl">الإجراءات الفورية:</h5>
                      <div class="space-y-3">
                        <div v-for="(action, index) in situation.actions" :key="action"
                             class="flex items-center justify-end bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-red-100 hover:border-red-200 transition-colors">
                          <span class="text-red-600 font-medium">{{ action }}</span>
                          <div class="mr-4 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center font-bold shadow-lg">
                            {{ index + 1 }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- FAQ Tab -->
          <div v-show="activeTab === 'faq'" class="p-8 lg:p-12">
            <div class="text-center mb-12">
              <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-violet-400 to-purple-500 rounded-2xl mb-6 shadow-lg">
                <span class="text-2xl">❓</span>
              </div>
              <h2 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                الأسئلة الشائعة
              </h2>
              <p class="text-xl text-gray-600">إجابات على أكثر الأسئلة شيوعاً</p>
            </div>

            <div class="space-y-6">
              <div v-for="(faq, index) in faqs" :key="index"
                   class="group relative">
                <div class="absolute inset-0 bg-gradient-to-r from-violet-400 to-purple-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl border border-gray-200/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                  <button
                    @click="toggleFAQ(index)"
                    class="w-full p-8 text-right hover:bg-gray-50/50 focus:outline-none focus:bg-gray-50/50 transition-colors"
                  >
                    <div class="flex items-center justify-between">
                      <div class="transform transition-transform duration-300" 
                            :class="openFAQs.includes(index) ? 'rotate-180' : ''">
                        <div class="w-8 h-8 bg-gradient-to-r from-violet-400 to-purple-500 rounded-full flex items-center justify-center shadow-lg">
                          <span class="text-white font-bold">▼</span>
                        </div>
                      </div>
                      <h3 class="text-xl font-bold text-gray-900 flex-1 mr-4">{{ faq.question }}</h3>
                    </div>
                  </button>
                  <div v-show="openFAQs.includes(index)" 
                       class="px-8 pb-8 text-right">
                    <div class="bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl p-6 border border-violet-200/50">
                      <p class="text-gray-700 text-lg leading-relaxed">{{ faq.answer }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Quick Contact CTA -->
        <div class="mt-16 relative">
          <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl blur-2xl opacity-20"></div>
          <div class="relative bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-white text-center shadow-2xl">
            <div class="max-w-3xl mx-auto">
              <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6">
                <span class="text-3xl">🤝</span>
              </div>
              <h3 class="text-4xl font-bold mb-4">تحتاج مساعدة فورية؟</h3>
              <p class="text-xl mb-8 opacity-90">فريق الدعم متاح 24/7 لمساعدتك في أي وقت</p>
              <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="tel:+966-XXX-XXXX" 
                   class="group relative inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg hover:bg-gray-50 transition-all duration-300 hover:scale-105 shadow-xl">
                  <span class="mr-3 text-2xl">📞</span>
                  اتصل بالدعم
                  <div class="absolute inset-0 bg-white/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
                <a href="https://wa.me/966XXXXXXXXX" 
                   class="group relative inline-flex items-center justify-center px-8 py-4 bg-green-500 text-white rounded-2xl font-bold text-lg hover:bg-green-400 transition-all duration-300 hover:scale-105 shadow-xl">
                  <span class="mr-3 text-2xl">💬</span>
                  واتساب
                  <div class="absolute inset-0 bg-green-400/20 rounded-2xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </HomeLayout>
</template>

<script setup>
import { ref } from 'vue'
import HomeLayout from '../Layouts/HomeLayout.vue'

const activeTab = ref('before')
const openFAQs = ref([])

const tabs = [
  { id: 'before', name: 'قبل الخدمة', icon: '📱' },
  { id: 'request', name: 'طلب الخدمة', icon: '🔧' },
  { id: 'waiting', name: 'انتظار الفني', icon: '⏱️' },
  { id: 'during', name: 'أثناء الخدمة', icon: '👨‍🔧' },
  { id: 'payment', name: 'الدفع', icon: '💳' },
  { id: 'emergency', name: 'الطوارئ', icon: '🚨' },
  { id: 'faq', name: 'أسئلة شائعة', icon: '❓' }
]

const safetyItems = [
  'انتقل إلى مكان آمن بعيداً عن حركة المرور',
  'شغّل أضواء التحذير (الفلاشر)',
  'تأكد من شحن هاتفك للتواصل',
  'ابق مع السيارة إلا إذا كان المكان خطيراً'
]

const carDocuments = [
  'رخصة القيادة',
  'استمارة السيارة', 
  'بوليصة التأمين',
  'الهوية الشخصية'
]

const additionalInfo = [
  'وصف دقيق للمشكلة',
  'الموقع بالتفصيل',
  'رقم الهاتف للتواصل',
  'نوع وموديل السيارة'
]

const serviceSteps = [
  {
    title: 'تسجيل الدخول إلى حسابك',
    description: 'ادخل إلى التطبيق أو الموقع الإلكتروني باستخدام بياناتك',
    details: [
      'تأكد من بيانات الدخول الصحيحة',
      'حدّث معلومات الملف الشخصي', 
      'تحقق من رصيد المحفظة'
    ]
  },
  {
    title: 'اختر نوع الخدمة المطلوبة',
    description: 'حدد نوع المساعدة التي تحتاجها من القائمة المتاحة',
    details: [
      'اقرأ وصف كل خدمة بعناية',
      'تحقق من الأسعار المتوقعة',
      'اختر الخدمة الأنسب لحالتك'
    ]
  },
  {
    title: 'أدخل التفاصيل والموقع',
    description: 'قدم معلومات دقيقة عن موقعك ومشكلة السيارة',
    details: [
      'حدد موقعك بدقة على الخريطة',
      'اكتب وصفاً واضحاً للمشكلة',
      'أضف رقم هاتفك للتواصل السريع'
    ]
  },
  {
    title: 'تأكيد وإرسال الطلب',
    description: 'راجع جميع التفاصيل وأرسل طلب الخدمة',
    details: [
      'تحقق من صحة جميع المعلومات',
      'اقرأ الشروط والأحكام',
      'اضغط على "تأكيد الطلب" للإرسال'
    ]
  }
]

const serviceTypes = [
  { name: 'مساعدة الطريق', icon: '🚗', description: 'عطل مفاجئ في الطريق' },
  { name: 'خدمة السحب', icon: '🚛', description: 'نقل السيارة لورشة الإصلاح' },
  { name: 'بطارية السيارة', icon: '🔋', description: 'تشغيل أو تغيير البطارية' },
  { name: 'تغيير الإطار', icon: '🛞', description: 'إطار مثقوب أو تالف' },
  { name: 'توصيل الوقود', icon: '⛽', description: 'نفاد الوقود' },
  { name: 'فتح السيارة', icon: '🔑', description: 'نسيان المفاتيح داخل السيارة' }
]

const expectations = [
  { title: 'وقت الوصول', icon: '⏰', description: '30-60 دقيقة عادة' },
  { title: 'اتصال الفني', icon: '📞', description: 'قبل الوصول بـ 10 دقائق' },
  { title: 'تحديث الموقع', icon: '📍', description: 'إشعارات في التطبيق' }
]

const dosList = [
  'تابع حالة الطلب في التطبيق',
  'اجعل هاتفك متاحاً للمكالمات',
  'جهز الوثائق المطلوبة',
  'انتظر في مكان آمن',
  'رد على رسائل الفني فوراً'
]

const dontsList = [
  'لا تترك موقعك دون إشعار',
  'لا تحاول إصلاح السيارة بنفسك',
  'لا تقبل خدمة من فنيين غير مرخصين',
  'لا تُلغي الطلب وتعيد إنشاؤه',
  'لا تدفع نقداً إلا عند الطلب'
]

const verificationItems = [
  'بطاقة هوية الفني',
  'رقم الفني في التطبيق',
  'زي أو شعار الشركة',
  'رقم لوحة المركبة'
]

const requestItems = [
  'اسمك وتفاصيل الطلب',
  'وقت الإصلاح المتوقع',
  'تكلفة الخدمة',
  'الضمان على العمل'
]

const duringServiceActions = [
  {
    title: 'راقب',
    icon: '👀',
    items: [
      'عملية الإصلاح',
      'القطع المستخدمة',
      'طريقة التعامل مع السيارة',
      'النظافة والاحترافية'
    ]
  },
  {
    title: 'اسأل',
    icon: '❓',
    items: [
      'عن سبب المشكلة',
      'عن الإصلاح المطلوب',
      'عن تكلفة القطع',
      'عن نصائح الصيانة'
    ]
  },
  {
    title: 'وثّق',
    icon: '📸',
    items: [
      'صور قبل الإصلاح',
      'صور أثناء العمل',
      'صور بعد الانتهاء',
      'إيصال الخدمة'
    ]
  }
]

const paymentMethods = [
  { name: 'فيزا/ماستركارد', icon: '💳', description: 'بطاقات ائتمان' },
  { name: 'مدى', icon: '💳', description: 'البطاقة السعودية' },
  { name: 'أبل باي', icon: '📱', description: 'الدفع عبر الهاتف' },
  { name: 'نقداً', icon: '💵', description: 'عند طلب الفني' }
]

const beforePaymentItems = [
  { text: 'راجع العمل المنجز مع الفني', icon: '📋' },
  { text: 'اختبر الإصلاح قبل مغادرة الفني', icon: '🔧' },
  { text: 'اطلب فاتورة مفصلة', icon: '🧾' },
  { text: 'تأكد من معلومات الضمان', icon: '🛡️' }
]

const appActions = [
  'قيّم الفني (1-5 نجوم)',
  'اكتب تعليقاً عن الخدمة',
  'احتفظ بإيصال الدفع',
  'سجل أي ملاحظات'
]

const followUpActions = [
  'احتفظ بالفاتورة للضمان',
  'تابع إذا استمرت المشكلة',
  'اتصل بالدعم عند الحاجة',
  'احجز خدمة دورية'
]

const emergencyContacts = [
  { type: 'الطوارئ العامة', number: '911', icon: '🚨', when: 'حوادث وإصابات' },
  { type: 'دعم العملاء', number: '+966-XXX-XXXX', icon: '📞', when: 'مشاكل الخدمة' },
  { type: 'الدعم الفني', number: '+966-XXX-XXXX', icon: '🛠️', when: 'مشاكل التطبيق' }
]

const emergencySituations = [
  {
    title: 'حادث مروري',
    icon: '🚗💥',
    description: 'في حالة وقوع حادث مروري مع إصابات أو أضرار',
    actions: [
      'اتصل بالإسعاف (997) فوراً',
      'اتصل بالمرور (993)',
      'لا تحرك السيارة إلا بإذن المرور',
      'اطلب خدمة السحب بعد انتهاء الإجراءات'
    ]
  },
  {
    title: 'عطل في مكان خطير',
    icon: '⚠️🛣️',
    description: 'عندما تتعطل السيارة في مكان يشكل خطراً على السلامة',
    actions: [
      'شغّل أضواء التحذير فوراً',
      'حاول الوصول لمكان آمن',
      'اتصل بالمرور للمساعدة',
      'اطلب خدمة السحب الطارئة'
    ]
  },
  {
    title: 'حريق في السيارة',
    icon: '🔥🚗',
    description: 'ظهور دخان أو رائحة احتراق من السيارة',
    actions: [
      'أوقف السيارة فوراً وأطفئ المحرك',
      'اخرج من السيارة بسرعة',
      'اتصل بالدفاع المدني (998)',
      'ابتعد عن السيارة مسافة آمنة'
    ]
  },
  {
    title: 'عطل ليلي',
    icon: '🌙🔧',
    description: 'عطل السيارة في الليل أو منطقة مظلمة وخطيرة',
    actions: [
      'شغّل أضواء التحذير والأضواء الداخلية',
      'ضع مثلث التحذير خلف السيارة',
      'ابق داخل السيارة مع قفل الأبواب',
      'اطلب خدمة طوارئ ليلية'
    ]
  }
]

const faqs = [
  {
    question: 'كم يستغرق وصول الفني عادة؟',
    answer: 'عادة ما يصل الفني خلال 30-60 دقيقة، وقد يختلف الوقت حسب الموقع ونوع الخدمة المطلوبة. ستحصل على تحديث بالوقت المتوقع فور تعيين فني لطلبك مع إمكانية تتبع موقعه.'
  },
  {
    question: 'ما هي طرق الدفع المقبولة في المنصة؟',
    answer: 'نقبل بطاقات الائتمان (فيزا/ماستركارد)، بطاقة مدى، أبل باي، والدفع النقدي عند الطلب. يتم الدفع بعد انتهاء الخدمة وتأكيد رضاك عن العمل المنجز.'
  },
  {
    question: 'هل يمكنني إلغاء الطلب بعد إرساله؟',
    answer: 'يمكنك إلغاء الطلب مجاناً خلال أول 5 دقائق من الإرسال. بعد تعيين الفني، قد تطبق رسوم إلغاء بسيطة. يمكنك الإلغاء من خلال التطبيق أو الاتصال بخدمة العملاء.'
  },
  {
    question: 'ماذا لو لم أكن راضياً عن جودة الخدمة؟',
    answer: 'رضاك مهم جداً لنا. إذا لم تكن راضياً، تواصل معنا خلال 24 ساعة وسنعمل على حل المشكلة فوراً. نوفر ضماناً على جميع خدماتنا ويمكن إعادة الفني مجاناً إذا لزم الأمر.'
  },
  {
    question: 'هل الخدمة متاحة على مدار الساعة؟',
    answer: 'نعم، نوفر خدمة الطوارئ على مدار 24 ساعة، 7 أيام في الأسبوع. قد تطبق رسوم إضافية للخدمة الليلية (من 10 مساءً إلى 6 صباحاً) وأيام العطل الرسمية.'
  },
  {
    question: 'ما هي الوثائق التي أحتاجها؟',
    answer: 'احضر رخصة القيادة، استمارة السيارة، وبطاقة الهوية الوطنية. في حالة التأمين، قد نحتاج لرقم البوليصة. تأكد من صحة جميع المعلومات لتجنب أي تأخير في الخدمة.'
  },
  {
    question: 'هل يغطي تأمين السيارة هذه الخدمات؟',
    answer: 'يعتمد على نوع وثيقة التأمين لديك. العديد من شركات التأمين تغطي خدمات المساعدة على الطريق. تحقق من وثيقة التأمين أو اتصل بشركة التأمين للتأكد من التغطية.'
  },
  {
    question: 'ماذا لو كانت سيارتي تحتاج قطع غيار؟',
    answer: 'سيقوم الفني بفحص السيارة شاملاً وإعلامك بالقطع المطلوبة وتكلفتها التفصيلية. لن يتم تركيب أي قطع دون موافقتك المسبقة والواضحة. نوفر قطع غيار أصلية ومضمونة.'
  }
]

const toggleFAQ = (index) => {
  if (openFAQs.value.includes(index)) {
    openFAQs.value = openFAQs.value.filter(i => i !== index)
  } else {
    openFAQs.value.push(index)
  }
}
</script>

<style scoped>
/* Smooth transitions */
* {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}

/* Custom animations */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Glassmorphism effect */
.backdrop-blur-xl {
  backdrop-filter: blur(20px);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(45deg, #3b82f6, #8b5cf6);
  border-radius: 8px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(45deg, #2563eb, #7c3aed);
}

/* RTL support */
[dir="rtl"] .space-x-reverse > * + * {
  margin-right: 0.5rem;
  margin-left: 0;
}

/* Text gradients */
.bg-clip-text {
  -webkit-background-clip: text;
  background-clip: text;
}

/* Hover effects */
.group:hover .group-hover\:scale-105 {
  transform: scale(1.05);
}

.group:hover .group-hover\:opacity-100 {
  opacity: 1;
}

/* Focus states */
button:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}

/* Mobile optimizations */
@media (max-width: 640px) {
  .text-5xl {
    font-size: 2.5rem;
  }
  
  .text-6xl {
    font-size: 3rem;
  }
}
</style>