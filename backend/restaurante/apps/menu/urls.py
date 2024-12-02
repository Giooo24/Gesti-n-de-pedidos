from django.urls import path
from .views import MenuListView, MenuItemDetailView

urlpatterns = [
    path('', MenuListView.as_view(), name='menu-list'),                 # GET, POST /api/menu/
    path('<int:id>/', MenuItemDetailView.as_view(), name='menu-detail'), # GET, PUT, DELETE /api/menu/{id}/
]

