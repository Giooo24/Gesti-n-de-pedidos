from django.shortcuts import render
from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status
from .models import MenuItem
from .serializers import MenuItemSerializer

class MenuListView(APIView):
    def get(self, request):
        """Obtener todos los ítems del menú."""
        items = MenuItem.objects.all()
        serializer = MenuItemSerializer(items, many=True)
        return Response(serializer.data)

    def post(self, request):
        """Crear un nuevo ítem en el menú."""
        serializer = MenuItemSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

class MenuItemDetailView(APIView):
    def get(self, request, id):
        """Obtener los detalles de un ítem específico del menú."""
        try:
            item = MenuItem.objects.get(id=id)
        except MenuItem.DoesNotExist:
            return Response({"error": "Menu item not found."}, status=status.HTTP_404_NOT_FOUND)

        serializer = MenuItemSerializer(item)
        return Response(serializer.data)

    def put(self, request, id):
        """Actualizar un ítem del menú."""
        try:
            item = MenuItem.objects.get(id=id)
        except MenuItem.DoesNotExist:
            return Response({"error": "Menu item not found."}, status=status.HTTP_404_NOT_FOUND)

        serializer = MenuItemSerializer(item, data=request.data, partial=True)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    def delete(self, request, id):
        """Eliminar un ítem del menú."""
        try:
            item = MenuItem.objects.get(id=id)
        except MenuItem.DoesNotExist:
            return Response({"error": "Menu item not found."}, status=status.HTTP_404_NOT_FOUND)

        item.delete()
        return Response({"message": "Menu item deleted successfully."}, status=status.HTTP_204_NO_CONTENT)

