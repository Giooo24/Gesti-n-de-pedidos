from django.urls import path
from .views import SalesListView, SalesStatsView

urlpatterns = [
    path('', SalesListView.as_view(), name='sales-list'),             # GET /api/sales/
    path('stats/', SalesStatsView.as_view(), name='sales-stats'),     # GET /api/sales/stats/
]

