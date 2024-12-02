from django.urls import path
from .views import ListOrdersView, CreateOrderView, UpdateOrderStatusView, DeleteOrderView

urlpatterns = [
    path('', ListOrdersView.as_view(), name='list-orders'),               # GET /api/orders/
    path('create/', CreateOrderView.as_view(), name='create-order'),      # POST /api/orders/create/
    path('<int:id>/status/', UpdateOrderStatusView.as_view(), name='update-order-status'),  # PUT /api/orders/{id}/status/
    path('<int:id>/', DeleteOrderView.as_view(), name='delete-order'),    # DELETE /api/orders/{id}/
]

