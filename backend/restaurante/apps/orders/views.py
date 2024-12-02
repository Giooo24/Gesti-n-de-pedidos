from django.shortcuts import render

from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status
from .models import Order
from .serializers import OrderSerializer, OrderCreateSerializer

class ListOrdersView(APIView):
    def get(self, request):
        """Listar todos los pedidos activos."""
        orders = Order.objects.filter(status='pending').order_by('-created_at')
        serializer = OrderSerializer(orders, many=True)
        return Response(serializer.data)

class CreateOrderView(APIView):
    def post(self, request):
        """Crear un nuevo pedido."""
        serializer = OrderCreateSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

class UpdateOrderStatusView(APIView):
    def put(self, request, id):
        """Actualizar el estado de un pedido."""
        try:
            order = Order.objects.get(id=id)
        except Order.DoesNotExist:
            return Response({"error": "Order not found."}, status=status.HTTP_404_NOT_FOUND)

        order.status = request.data.get('status', order.status)
        order.save()
        serializer = OrderSerializer(order)
        return Response(serializer.data)

class DeleteOrderView(APIView):
    def delete(self, request, id):
        """Eliminar un pedido cancelado."""
        try:
            order = Order.objects.get(id=id)
        except Order.DoesNotExist:
            return Response({"error": "Order not found."}, status=status.HTTP_404_NOT_FOUND)

        order.delete()
        return Response({"message": "Order deleted successfully."}, status=status.HTTP_204_NO_CONTENT)

