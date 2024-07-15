import 'package:equatable/equatable.dart';

/// Modèle de [Bike] standard et réutilisable
/// pour pouvoir utiliser et mapper les données reçu de l'API
//TODO: Éventuellement utilisé pour la base de données aussi
final class Bike extends Equatable {
  final String brand;
  final String model;

  const Bike({
    required this.brand,
    required this.model,
  });

  @override
  List<Object> get props => [brand, model];
}
