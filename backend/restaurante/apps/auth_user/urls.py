from django.urls import path
from .views import RegisterView, LoginView, ProfileView

urlpatterns = [
    path('register/', RegisterView.as_view(), name='register'),  # POST /api/auth/register/
    path('login/', LoginView.as_view(), name='login'),           # POST /api/auth/login/
    path('profile/', ProfileView.as_view(), name='profile'),     # GET /api/auth/profile/
]

