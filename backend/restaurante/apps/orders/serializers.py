from rest_framework import serializers
from .models import Order
from apps.menu.serializers import MenuItemSerializer 

class OrderSerializer(serializers.ModelSerializer):
    items = MenuItemSerializer(many=True, read_only=True)  # Leer los datos de los ítems

    class Meta:
        model = Order
        fields = ['id', 'customer_name', 'table_number', 'items', 'status', 'created_at', 'updated_at']

class OrderCreateSerializer(serializers.ModelSerializer):
    class Meta:
        model = Order
        fields = ['customer_name', 'table_number', 'items', 'status']

